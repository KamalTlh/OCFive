<?php
namespace controller;

class UserController extends Controller{

    public function login($post){
        if(isset($post['pseudo']) && isset($post['password'])){
            $data = $this->userModel->login($post['pseudo'], $post['password']);
            if($data && $data['isPasswordValid']){
                $data['role'] = $this->userModel->checkUserRole($post['pseudo']);
                $this->session->set('login', true);
                $this->session->set('user_id', $data['user']['id'] );
                $this->session->set('pseudo', $post['pseudo']);
                $this->session->set('role', $data['role']);
                $data['sessionConnected'] = $this->session->get('login');
                $data['sessionUserId'] = $this->session->get('user_id');
                $data['sessionPseudo'] =$this->session->get('pseudo');
                $data['role'] =$this->session->get('role');
            }
            else {
                $this->session->set('login', false);
                $data['sessionConnected'] = $this->session->get('login');
            }
            return $this->view->render('JsonResponse',[
                'data'=> $data,
            ]);
        }
        $data['data'] = 'Erreur lors du traitement des données. Veuillez réessayer plus tard.';
        $data['errorData'] = true;
        return $this->view->render('JsonResponse',[
            'data'=> $data
        ]);
    }

    public function SignIn($post){
        if(isset($post['pseudo']) && isset($post['email']) && isset($post['password'])){
            $data['errors'] = $this->validation->validate($post, 'User');
            if($this->userModel->isPseudoUnique($post, '')){
                $data['errors']['pseudo'] = $this->userModel->isPseudoUnique($post, '');
            }
            if($this->userModel->isEmailUnique($post, '')){
                $data['errors']['email'] = $this->userModel->isEmailUnique($post, '');
            }
            if(!($data['errors'])){
                $data = $this->userModel->signIn($post['pseudo'], $post['email'], $post['password']);
                $this->session->set('account_created', 'Le compte a été crée.');
                $data['sessionAccountCreated'] =$this->session->get('account_created');
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
                // if($this->session->get('role') === 'admin'){
                //     $this->session->set('account_created', 'Le compte a été crée.');
                // }
                // else{
                // $this->session->set('first_login', 'Vous pouvez vous connectez');
                // header('Location: index.php?route=login');
                // }
            }
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }

    public function getUsers($get){
        if($get['userLoggedRole'] == 1 ) {
            if($get['totalPages'] == 0){
                $data['page'] = $this->usersModel->getCountListUsers();;
            }
            $data['datas'] = $this->usersModel->getListUsers();;
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Vous n\'avez pas les droits d\'accès.'
        ]);
    }
    
    public function readUser($userId){
        if($this->checkLoggedIn()){
            $user = $this->userModel->getUser($userId);
            return $this->view->render('profile', [
                'user'=> $user
            ]);
        }
    }

    public function updateUser($post){
        if(isset($post['userLoggedPseudo'])) {
            if(isset($post['pseudo']) && isset($post['email']) && isset($post['id'])){
                $data['errors'] = $this->validation->validate($post, 'User');
                $data['role_id'] = $this->userModel->checkUserRole($post['userLoggedPseudo']);
                if($this->userModel->isPseudoUnique($post, $post['id'])){
                    $data['errors']['pseudo'] = $this->userModel->isPseudoUnique($post, $post['id']);
                }
                if($this->userModel->isEmailUnique($post, $post['id'])){
                    $data['errors']['email'] = $this->userModel->isEmailUnique($post, $post['id']);
                }
                if( !empty($data['errors'])){
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]);
                }
                elseif($data['role_id']['role_id'] = 1){
                    $data = $this->userModel->updateUserByAdmin($post);
                    $this->session->set('user_updatedByAdmin', 'Les informations de l\'utilisateur ont été mis à jour.');
                    $data['sessionUpdatedByAdmin'] = $this->session->get('user_updatedByAdmin');
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]);
                }
                else{
                    $data = $this->userModel->updateUser($post);
                    $this->session->set('user_updatedByUser', 'Vos informations ont été mises à jour.');
                    $data['sessionUpdatedByUser'] = $this->session->get('user_updatedByUser');
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]);
                }
            }
            return $this->view->render('JsonResponse',[
                'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Vous n\'avez pas les droits d\'accès.'
        ]);
    }


    public function deleteUser($post){
        $data = $this->userModel->checkUserRole($post['userLoggedPseudo']);
        if($data['role_id'] == 1 ){
            $data = $this->userModel->deleteUser($post['id']);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]); 
            $this->logoutOrDelete('delete');
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Vous n\'avez pas les droits d\'accès.'
        ]);
    }

    public function checkPassword($password, $userId){
        if(isset($password) && isset($userId)){
            $data['passwordCorrect'] = $this->userModel->checkPassword($password, $userId);
            if($data['passwordCorrect']){
                $this->session->set('password_correct', 'Le mot de passe est correct.');
                $data['sessionPassword_correct'] = $this->session->get('password_correct');
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]); 
            }
            $data['errorCurrentPassword'] = 'Le mot de passe est incorrect.';
            return $this->view->render('updatepassword', [
                'data' => $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }

    public function updatePassword($post){
        if($this->checkLoggedIn()){
            if(isset($post)){
                $data = $this->checkPassword($post['currentPassword'], $post['userId']);
                $data['errors'] = $this->validation->validate($post, 'User');
                if( $data['passwordCorrect'] && !$data['errors']){
                    $data = $this->userModel->updatePassword($post['newPassWordOne'], $post['userId']);
                    return $this->view->render('JsonResponse', [
                        'data' => $data
                    ]);
                }
                return $this->view->render('JsonResponse', [
                    'data' => $data
                ]);
            }
            return $this->view->render('JsonResponse',[
                'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Veuillez vous connectez.'
        ]);
    }

    public function logout(){
        $this->logoutOrDelete('logout');
    }

    public function logoutOrDelete($type){
        if($type === 'logout'){
            $this->session->stop();
            $this->session->start();
            $this->session->set('sessionConnected', false);
            $data['sessionConnected']= $this->session->get('sessionConnected');
            return $this->view->render('JsonResponse', [
                'data' => $data
            ]);
        }
        else{
            if($this->session->get('role') === 'admin'){
                $this->session->set('account_delete', 'Le compte a été supprimé');
                $data['sessionAccount_Delete']= $this->session->get('account_delete');
                return $this->view->render('JsonResponse', [
                    'data' => $data
                ]);
            }
            else{
                $this->session->stop();
                $this->session->start();
                $this->session->set('account_delete', 'Votre compte a été supprimé');
                $data['sessionAccount_Delete']= $this->session->get('account_delete');
                return $this->view->render('JsonResponse', [
                    'data' => $data
                ]);
            }
        }
    }
}