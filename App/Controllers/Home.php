<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\User;
use \App\Models\Iot;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends Authenticated
{

    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $this->iot = new Iot;
        
        $countUser = $this->user::countUser();
        // $allMembers = $this->user::allMembers();
        // $switches = $this->iot->switches($this->user->unique_id);
        
        // $switch_array = str_split($switches, 1);
        
        $usedSwitch = 0;
        $freeSwitch = 0;
        $datas = $this->iot->data(32120);
        unset($datas->id);
        unset($datas->unique_id);
        foreach($datas as $data) {
            if ($data == 1) {
                $usedSwitch ++;
            } else {
                $freeSwitch ++;
            }
        }
        

        View::renderTemplate('Home/index.html', [
            'user' => $this->user,
            'countUser' => $countUser,
            'usedSwitch' => $usedSwitch,
            'freeSwitch' => $freeSwitch,
            // 'members' => $allMembers,
            // 'switch1' => $switch_array[0],
            // 'switch2' => $switch_array[1],
            // 'switch3' => $switch_array[2],
            // 'switch4' => $switch_array[3],
            'url' => 'home'
        ]);
        
        // $this->redirect('/iot/data');
        
    }

    

    /**
     * Show the index page
     *
     * @return void
     */
    public function allmembersAction()
    {
        $allMembers = $this->user::allMembers();

        View::renderTemplate('Home/allmembers.html', [
            'members' => $allMembers
        ]);
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function changepasswordAction()
    {
        $allMembers = $this->user::allMembers();

        View::renderTemplate('Home/changepassword.html', [
            'url' => 'password'
        ]);
    }

    /**
     * Show the dalete page
     *
     * @return void
     */
    public function updatepasswordAction()
    {

        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Password Updated');

            $this->redirect('/home/changepassword');

        } else {

            View::renderTemplate('Home/changepassword.html', [
                'user' => $this->user,
                'url' => 'password'
            ]);

        }
    }

    /**
     * Show the dalete page
     *
     * @return void
     */
    public function deleteAction()
    {

        if ($this->user->delete($_GET['id'])) {

            Flash::addMessage('Deleted');

            $this->redirect('/home/allmembers');

        } else {

            Flash::addMessage('Oops something went wrong!');

            $this->redirect('/home/allmembers');

        }
    }

}