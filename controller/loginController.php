
<?php

if(file_exists('dao/livrosDAO.php')){
    require_once 'dao/livrosDAO.php';
}else if(file_exists('../DAO/livrosDAO.php')){
    require_once '../DAO/livrosDAO.php';
}else if(file_exists('../../DAO/livrosDAO.php')){
    require_once '../../DAO/livrosDAO.php';
}

switch ($_POST['action']) {
    case 'login':
        $login = preg_replace('/[^[:alnum:]_]/', '', isset($_POST['login']) ? $_POST['login'] : '');
        $pass = preg_replace('/[^[:alnum:]_]/', '', isset($_POST['senha']) ? $_POST['senha'] : '');
        $senha = md5($pass);

        $dao = new livrosDAO();
        $userVerify = $dao->login($login,$senha);
        if ($userVerify) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $userVerify[0]['id_usuario'];
            $_SESSION['user_name'] = $userVerify[0]['nome'];
            $_SESSION['user_login'] = $userVerify[0]['login'];
            
           
            echo json_encode('ok');
        } else {
            echo json_encode(false);
        }

        break;

        break;
    case 'newLogin':
        $userId = preg_replace('/[^[:alnum:]_]/', '', isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '');
        $userLogin = preg_replace('/[^[:alnum:]_]/', '', isset($_SESSION['user_login']) ? $_SESSION['user_login'] : '');
        $newPass = preg_replace('/[^[:alnum:]_]/', '', isset($_POST['pass']) ? $_POST['pass'] : '');
        $user = new Usuario();
        $user->setId($userId);
        $user->setSenha(md5($newPass));
        $user->setLogin($userLogin);

        $loginModel = new loginModel();
        $newLogin = $loginModel->updateLogin($user);
        $userVerify = $loginModel->verificaLogin($user);


        if ($userVerify) {
            if ($userVerify['Ativado'] == 1) {
                $session = $user->createSession($userVerify['login'], $userVerify['IdUsuario'], $userVerify['Usuario'], $userVerify['Ativado']);
                echo ('ok');
            } else {
                $session = $user->createSession($userVerify['login'], $userVerify['IdUsuario'], $userVerify['Usuario'], $userVerify['Ativado']);
                echo ('new'); // for new users
            }
        } else {
            echo ('erro');
        }

        break;
    case 'logout':
        session_start();
        $_SESSION['logged_in'] = false;
        $_SESSION['user_id'] = '';
        $_SESSION['user_name'] = '';
        $_SESSION['user_login'] = '';
        session_destroy();
        echo json_encode('true');
        break;
    default:
        # code...
        break;
}

