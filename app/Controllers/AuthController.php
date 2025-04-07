<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // Show login form
    public function login()
    {
        if (session()->get('user')) {
            return redirect()->to('/products');
        }
        return view('auth/login');
    }

    // Handle login form submit
    public function doLogin()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        
        if ($user && password_verify($password, $user['password'])) {
            
            $session->set('user', [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
            ]);

            return redirect()->to('/products');
        }

        return redirect()->back()->with('error', 'Invalid credentials')->withInput();
    }

    // Show signup form
    public function signup()
    {
        if (session()->get('user')) {
            return redirect()->to('/products');
        }
        return view('auth/signup');
    }

    // Handle signup form submit
    public function register()
    {
        $validation = \Config\Services::validation();

        $data = $this->request->getPost();
        $validation->setRules([
            'name'              => 'required|min_length[3]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'password'          => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
                'errors' => [
                    'regex_match' => 'Password must contain at least 1 uppercase letter, 1 number, and 1 special character.'
                ]
            ],
            'confirm_password'  => 'required|matches[password]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        $userModel = new UserModel();

        $userModel->save([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        return redirect()->to('/')->with('success', 'Account created successfully. Please login!');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}