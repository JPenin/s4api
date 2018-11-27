<?php

namespace App\Controller;

use App\Services\ValidateUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestAuthController
 *
 * @package App\Controller
 */
class RestAuthController extends AbstractController
{
    protected $validateUser;

    public function __construct(ValidateUser $validateUser)
    {
        $this->validateUser = $validateUser;
    }

    /**
     * @Route("/rest/auth", name="rest_auth_entrypoint", methods={"POST"})
     */
    public function restAuthAction()
    {
        $emailPasswordMatch = false;

        // obtengo los parámetros sólo vía POST, restricción en las annotations, por lo que
        // no chequeo esa situación aquí. Al ser la aplicación tolerante a errores me he tomado esa licencia.
        $request = Request::createFromGlobals();

        $email    = $request->request->get('email');
        $password = $request->request->get('password');

        $emailExists = $this->validateUser->userExists($email);

        if($emailExists){
            $emailPasswordMatch = $this->validateUser->emailAndPasswordMatches($email, $password);
        }

        return new JsonResponse(
            [
                'EmailExists'        => $emailExists,
                'EmailPasswordMatch' => $emailPasswordMatch
            ],
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Versión GET del endpoint. Hecho exclusivamente para que se pueda probar la aplicación
     * sin tener que usar un Postman o derivados.
     *
     * @Route("/rest/auth/{email}/{password}", name="rest_auth_get_entrypoint", methods={"GET"})
     */
    public function restAuthGetAction($email, $password)
    {
        $emailPasswordMatch = false;

        $emailExists = $this->validateUser->userExists($email);

        if($emailExists){
            $emailPasswordMatch = $this->validateUser->emailAndPasswordMatches($email, $password);
        }

        return new JsonResponse(
            [
                'EmailExists'        => $emailExists,
                'EmailPasswordMatch' => $emailPasswordMatch
            ],
            JsonResponse::HTTP_OK
        );
    }
}
