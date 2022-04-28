<?php
use  \Dotenv\Dotenv;
class EnviromentServiceProvider extends \Carbon\Laravel\ServiceProvider
{

    public function register(){
       try{
         $env=Dotenv::createImmutable(base_path());
         $env->load();
       }catch (Exception $ex){

       }
    }
    public function boot(){

    }
}