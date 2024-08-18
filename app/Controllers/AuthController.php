<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login_process()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            if ($password == $pass) {
                $verify_pass = true;
            } else {
                $verify_pass = false;
            }
            if ($verify_pass) {
                $ses_data = [
                    'id_user'       => $data['id_user'],
                    'username'    => $data['username'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/auth');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/auth');
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}
