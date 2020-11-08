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
                $data['sessionAccountCreated'] = 'Le compte a été crée.';
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
            $accessAdmin = $this->checkAuthAdmin();
            if($accessAdmin['admin'] === true ) {
                if($get['totalPages'] == 0){
                    $data['page'] = $this->usersModel->getCountListUsers();;
                }
                $data['datas'] = $this->usersModel->getListUsers();;
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
            }
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
            // $accessAdmin = $this->checkAuthAdmin();
            if(isset($post['pseudo']) && isset($post['email']) && isset($post['id'])){
                $data['errors'] = $this->validation->validate($post, 'User');
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
                elseif($this->checkAuthAdmin()){
                    $data = $this->userModel->updateUserByAdmin($post);
                    $data['sessionUpdatedByAdmin'] = 'Les informations de l\'utilisateur ont été mis à jour.';
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]);
                }
                else{
                    $data = $this->userModel->updateUser($post);
                    $data['sessionUpdatedByUser'] = 'Vos informations ont été mises à jour.';
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]);
                }
            }
            return $this->view->render('JsonResponse',[
                'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
            ]);
        }
    }


    public function deleteUser($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $accessAdmin = $this->checkAuthAdmin();
            if($accessAdmin['admin'] === true ){
                $data = $this->userModel->checkUserRole($post['userLoggedPseudo']);
                if($data['role_id'] == 1 ){
                    $data = $this->commentsModel->deleteCommentsUser($post['id']);
                    $data = $this->favoritesModel->deleteFavoritesUser($post['id']);
                    $data = $this->proSanteModel->deleteRatesUser($post['id']);
                    $data = $this->userModel->deleteUser($post['id']);
                    return $this->view->render('JsonResponse',[
                        'data'=> $data
                    ]); 
                }
            }
        }
    }

    public function checkPassword($password, $userId){
        if(isset($password) && isset($userId)){
            $data['isPasswordCorrect'] = $this->userModel->checkPassword($password, $userId);
            if($data['isPasswordCorrect']){
                $data['passwordCorrect'] = true;
                return $data;
            }
            else{
                $data['error'] = 'Le mot de passe est incorrect.';
                return $data;
            }
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }

    public function updatePassword($post){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            if( isset($post['password']) && isset($post['passwordOne']) && isset($post['passwordTwo']) ){
                $data = $this->checkPassword($post['password'], $post['userId']);
                $data['errors'] = $this->validation->validate($post, 'User');
                if( isset($data['passwordCorrect']) && $data['passwordCorrect'] && !$data['errors']){
                    if ($post['passwordOne'] == $post['passwordTwo']){
                        $update['passwordUpdated'] = $this->userModel->updatePassword($post['passwordOne'], $post['userId']);
                        return $this->view->render('JsonResponse', [
                            'update' => $update
                        ]);
                    }
                }
                return $this->view->render('JsonResponse', [
                    'data' => $data
                ]);
            }
            $data['data'] = 'Erreur lors du traitement des données. Veuillez réessayer plus tard.';
            $data['errorData'] = true;
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
    }

    public function logout(){
        $check = $this->checkAuth();
        if ($check['access'] === true){
            $data['sessionConnected']= false;
            return $this->view->render('JsonResponse', [
                'data' => $data,
                'message' => 'User Logout.'
            ]);
        }
    }

    public function getUserPreferences($get){
        $check = $this->checkAuth();
        if ($check['access'] === true){
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
}