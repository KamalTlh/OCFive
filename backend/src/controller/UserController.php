<?php
namespace MyApp\Controller;
use \Firebase\JWT\JWT;

class UserController extends Controller{
    
    public function login($post){
        if(isset($post['pseudo']) && isset($post['password'])){
            $result = $this->userModel->login($post['pseudo'], $post['password']);
            if($result && $result['isPasswordValid']){
                $result['role'] = $this->userModel->checkUserRole($post['pseudo']);
                /*-- jwt-auth --*/
                $data = $this->lookAuth($result['user']);
                /*---*/
            }
            else {
                $data['isPasswordValid'] = $result['isPasswordValid'];
                $data['message'] = "Login failed";
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
        $check = $this->checkAuth();
        if ($check['access'] === true){
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
    }
    
    public function readUser($userId){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $user = $this->userModel->getUser($userId);
            return $this->view->render('profile', [
                'user'=> $user
            ]);
        }
    }

    public function updateUser($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
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
    }


    public function deleteUser($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $data = $this->userModel->checkUserRole($post['userLoggedPseudo']);
            if($data['role_id'] == 1 ){
                $data = $this->commentsModel->deleteCommentsUser($post['id']);
                $data = $this->favoritesModel->deleteFavoritesUser($post['id']);
                $data = $this->proSanteModel->deleteRatesUser($post['id']);
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
    }

    public function checkPassword($password, $userId){
        if(isset($password) && isset($userId)){
            $data['passwordCorrect'] = $this->userModel->checkPassword($password, $userId);
            if($data['passwordCorrect']){
                $this->session->set('password_correct', 'Le mot de passe est correct.');
                $data['sessionPassword_correct'] = $this->session->get('password_correct');
                return $data;
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
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if(isset($post)){
                $data = $this->checkPassword($post['currentPassword'], $post['userId']);
                $data['errors'] = $this->validation->validate($post, 'User');
                if( $data['passwordCorrect'] && !$data['errors']){
                    if ($post['newPasswordOne'] == $post['newPasswordTwo']){
                        $data['passwordUpdated'] = $this->userModel->updatePassword($post['newPasswordOne'], $post['userId']);
                        return $this->view->render('JsonResponse', [
                            'data' => $data
                        ]);
                    }
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
                'data' => $data,
                'message' => 'User Logout.'
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

    public function getUserPreferences($get){
        if (isset($get['userId']) && isset($get['workerId']) ){
            $data = $this->userModel->getUserPreferences($get['userId'], $get['workerId']);
            return $this->view->render('JsonResponse', [
                'data' => $data
            ]);
        }
        else {
            return $this->view->render('JsonResponse',[
                'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
            ]);
        }
    }
}