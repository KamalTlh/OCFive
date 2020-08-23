<?php
namespace controller;

class UserController extends Controller{

    public function login($pseudo, $password){
        if(isset($pseudo) && isset($password)){
            // $errors = $this->validation->validate($post, 'User');
            $data = $this->userModel->login($pseudo, $password);
            // $role = $this->userModel->checkUserRole($post['userlog']);
            if($data && $data['isPasswordValid']){
                $this->session->set('login', true);
                $this->session->set('user_id', $data['user']['id'] );
                $this->session->set('pseudo', $pseudo);
                $data['sessionConnected'] = $this->session->get('login');
                $data['sessionUserId'] = $this->session->get('user_id');
                $data['sessionPseudo'] =$this->session->get('pseudo');
                // $this->session->set('role', $role['result']);
            }
            else {
                $this->session->set('login', false);
                $data['sessionConnected'] = $this->session->get('login');
            }
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]);
        }
        return $this->view->render('JsonResponse',[
            'data'=> 'Erreur lors du traitement des données. Veuillez réessayer plus tard.'
        ]);
    }

    public function SignIn($pseudo, $email, $password){
        if(isset($pseudo) && isset($email) && isset($password)){
            $errors = null;
            // $errors = $this->validation->validate($post, 'User');
            // if($this->userModel->isPseudoUnique($post, '')){
            //     $errors['pseudo'] = $this->userModel->isPseudoUnique($post, '');
            // }
            // if($this->userModel->isEmailUnique($post, '')){
            //     $errors['email'] = $this->userModel->isEmailUnique($post, '');
            // }
            if(!($errors)){
                $data = $this->userModel->signIn($pseudo, $email, $password);
                return $this->view->render('JsonResponse',[
                    'data'=> $data
                ]);
                // if($this->session->get('role') === 'admin'){
                //     $this->session->set('account_created', 'Le compte a été crée.');
                //     header('Location: index.php?route=administration');
                // }
                // else{
                // $this->session->set('first_login', 'Vous pouvez vous connectez');
                // header('Location: index.php?route=login');
                // }
            }
            // return $this->view->render('createuser',[
            //     'post'=> $post,
            //     'errors'=> $errors
            // ]);
        }
        // return $this->view->render('createuser');
    }

    public function getUsers($get){
        if($_GET['totalPages'] == 0){
            $data['page'] = $this->usersModel->getCountListUsers();;
        }
        $data['datas'] = $this->usersModel->getListUsers();;
        return $this->view->render('JsonResponse',[
            'data'=> $data
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

    public function updateUser($post, $userId){
        if($this->checkLoggedIn()){
            if(isset($post['submit'])){
                $errors = $this->validation->validate($post, 'User');
                $user = $this->userModel->getUser($userId);
                if($this->userModel->isPseudoUnique($post, $userId)){
                    $errors['pseudo'] = $this->userModel->isPseudoUnique($post, $userId);
                }
                if($this->userModel->isEmailUnique($post, $userId)){
                    $errors['email'] = $this->userModel->isEmailUnique($post, $userId);
                }
                if(!($errors)){
                    $this->userModel->updateUser($post, $userId);
                    if ($this->session->get('role') === 'admin'){
                        $this->session->set('user_updatedByAdmin', 'Les informations de l\'utilisateur ont été mis à jour.');
                        header('Location: index.php?route=administration');
                    }
                    else{
                        $this->session->set('user_updated', 'Vos informations ont été mises à jour.');
                        header('Location: index.php');
                    }
                }
                return $this->view->render('profile',[
                    'post'=> $post,
                    'userId' => $userId,
                    'user' => $user,
                    'errors'=> $errors
                ]);
            }
        }
    }

    public function deleteUser($userId){
        // if($this->checkLoggedIn()){
            $data = $this->userModel->deleteUser($userId);
            return $this->view->render('JsonResponse',[
                'data'=> $data
            ]); 
            $this->logoutOrDelete('delete');
        // }
    }

    public function updatePassword($post, $userId){
        if($this->checkLoggedIn()){
            if(isset($post['submit'])){
                $errors = $this->validation->validate($post, 'User');
                if( $post['password'] && $post['password'] === $post['verified_password']){
                    $this->userModel->updatePassword($post, $userId);
                    $this->session->set('password_updated', 'Le mot de passe a été mis à jour.');
                    header('Location: index.php?route=profile&userId='.$userId);
                }
                $this->session->set('error_password', 'Les mots de passe ne correspondent pas.');
                return $this->view->render('updatepassword', [
                    'userId' => $userId,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('updatepassword', [
                'userId' => $userId
            ]);
        }
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

    public function profile($userId){
        if($this->checkLoggedIn()){
            $user = $this->userModel->getUser($userId);
            return $this->view->render('profile', [
                'user' => $user
            ]);
        }
    }

    // public function administration(){
    //     if($this->checkLoggedIn() && $this->checkAdmin()){
    //         $articles = $this->articlesModel->getListArticles();
    //         $comments = $this->commentsModel->getListComments();
    //         $flagComments = $this->commentsModel->getFlagComments();
    //         $users = $this->usersModel->getListUsers();
    //         return $this->view->render('admin/administration', [
    //             'articles'=> $articles,
    //             'comments' => $comments,
    //             'flagComments'=> $flagComments,
    //             'users'=> $users
    //         ]);
    //     }
    // }
}