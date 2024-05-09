<?php
namespace app\controller;
use app\core\Application;
use app\core\Controllers;
use app\core\Request;
use app\model\Contact;

class Sitecontroller extends Controllers{
    public function contact(Request $request){
        Application::$app->title = "Contact";
        $contact = new Contact();

        if($request->getmethod() == 'post'){
            $contact->LoadData($request->getBody());
                if($contact->validateData() ){
                    Application::$app->session->createFlash('success','Thank you for contacting Us. ','success');
                    header('Location: /contact');
                    exit();
                }
        }
        return Application::$app->router->render('contact',[
            'model' => $contact
        ]);
    }
    public function home(){
        Application::$app->title = "Home";
        return Application::$app->router->render('home');
    }
};