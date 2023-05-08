<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Dbgeter;
use \App\Flash;

/**
 * Iot controller
 *
 * PHP version 7.0
 */
class Iot extends \Core\Controller
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

        $this->iot = Dbgeter::Iot();
    }

    /**
     * Show the data page
     *
     * @return void
     */
    public function dataAction()
    {
        $out = [];
        $datas = $this->iot->data(32120);
        unset($datas->id);
        unset($datas->unique_id);
        foreach($datas as $data) {
            array_push($out, $data);
        }
        echo "AckOk".implode('', $out);
    }

    /**
     * Show the data page
     *
     * @return void
     */
    public function graphAction()
    {
        if (!$this->user) {
            Flash::addMessage('Please login to access this page.');
            $this->redirect('/login');
        }
        
        $current1 = $this->iot->Current1($this->user->unique_id);
        $current2 = $this->iot->Current2($this->user->unique_id);
        $current3 = $this->iot->Current3($this->user->unique_id);
        $battery = $this->iot->Battery($this->user->unique_id);

        $times = $this->iot->time($this->user->unique_id);

        $a2s_current1 = implode(",", $current1);
        $a2s_current2 = implode(",", $current2);
        $a2s_current3 = implode(",", $current3);
        $a2s_battery = implode(",", $battery);

        View::renderTemplate('Iot/graph.html', [
            'current1' => $a2s_current1,
            'current2' => $a2s_current2,
            'current3' => $a2s_current3,
            'battery' => $a2s_battery,
            'times' => $times,
            'url' => 'graph'
        ]);

    }

    /**
     * Incoming save to database
     *
     * @return void
     */
    public function saveAction()
    {
        // $f_energy = $this->iot->Energy($this->route_params['uniqueid'])[array_key_last($this->iot->Energy($this->route_params['uniqueid']))] ?? null;
        // $voltage = $this->route_params['voltage'];
        // $current = $this->route_params['current'];
        // $time = $this->route_params['time'];
        // $power = ($voltage * $current) / 1000;
        // $energy = $f_energy ? $f_energy + round(substr((($power * $time) / 3600), 0, 12), 6) : round(substr((($power * $time) / 3600), 0, 12), 6);


        // $data = [ "unique_id" => $this->route_params['uniqueid'], "voltage" => $voltage, "current" => $current, "power" => $power, "energy" => $energy ];
        
        // $switches = $this->iot->switches($this->user->unique_id);

        // if ($this->iot->save($data)) {

        //     echo "AckOk".$switches;

        //     return "AckOk";

        // } else {

        //     echo "Sorry an error occured!";
        // }
        
        $current1 = $this->route_params['current1'];
        $current2 = $this->route_params['current2'];
        $current3 = $this->route_params['current3'];
        $battery = $this->route_params['battery'];

        $data = [ "unique_id" => $this->route_params['uniqueid'], "current1" => $current1, "current2" => $current2, "current3" => $current3, "battery" => $battery ];
        

        if ($this->iot->save($data)) {

            echo "AckOk";

            return "AckOk";

        } else {

            echo "Sorry an error occured!";
        }

    }
    
    /**
     * Incoming save to database
     *
     * @return void
     */
    public function switchAction()
    {
        $switch1 = $_GET["switch1"];
        $switch2 = $_GET["switch2"];
        $switch3 = $_GET["switch3"];
        $switch4 = $_GET["switch4"];
        
        $switch = $switch1.$switch2.$switch3.$switch4;

        if ($this->iot->updateSwitch($this->user->unique_id, $switch)) {

            $this->redirect('/');

        } else {

            $this->redirect('/');
        }

    }
    
    /**
     * Show the index page
     *
     * @return void
     */
    public function switchesAction()
    {
        $out = [];
        $datas = $this->iot->data(32120);
        unset($datas->id);
        unset($datas->unique_id);
        foreach($datas as $data) {
            array_push($out, $data);
        }
        
        View::renderTemplate('Home/switches.html', [
            'user' => $this->user,
            'url' => 'switches',
            'datas' => $out
        ]);
    }
    
    /**
     * Show the index page
     *
     * @return void
     */
    public function subscribeAction()
    {
        $out = [];
        $datas = $this->iot->data(32120);
        unset($datas->id);
        unset($datas->unique_id);
        foreach($datas as $data) {
            array_push($out, $data);
        }
        
        $ran = array_rand($out,1);
        $available;
        
        $count = 0;
        
        while($count < 20){
            $ran = array_rand($out,1);
            if ($out[$ran] == 0) {
                $available = $ran+1;
                break;
            }
            $count ++;
        }
        
        // foreach($out as $ot) {
        //     if ($ot != 1) {
        //         $available = $ot;
        //         break;
        //     }
        // }
        
        View::renderTemplate('Home/subscribe.html', [
            'user' => $this->user,
            'url' => 'switches',
            'datas' => $out,
            'available' => $available
        ]);
    }
    
    /**
     * Show the index page
     *
     * @return void
     */
    public function setsubAction()
    {
        
        View::renderTemplate('Home/setsub.html', [
            'user' => $this->user,
            'url' => 'switches'
        ]);
    }
    
    /**
     * Show the dalete page
     *
     * @return void
     */
    public function payAction()
    {

        if ($this->iot->changeSwitch($_GET['switch'], 1)) {
            
            $this->user->updateOnSwitch($_GET['switch']);

            Flash::addMessage('Successful.');

            $this->redirect('/switches');

        } else {

            Flash::addMessage('Oops something went wrong!');

            $this->redirect('/switches');

        }
    }
    
    /**
     * Show the dalete page
     *
     * @return void
     */
    public function changeswitchAction()
    {

        if ($this->iot->changeSwitch($_GET['switch'], $_GET['value'])) {

            Flash::addMessage('Changed.');

            $this->redirect('/switches');

        } else {

            Flash::addMessage('Oops something went wrong!');

            $this->redirect('/switches');

        }
    }
    
    /**
     * Show the dalete page
     *
     * @return void
     */
    public function changeallswitchAction()
    {

        if ($this->iot->changeAllSwitch($_GET['value'])) {

            Flash::addMessage('Changed.');

            $this->redirect('/switches');

        } else {

            Flash::addMessage('Oops something went wrong!');

            $this->redirect('/switches');

        }
    }
    
    /**
     * Show the index page
     *
     * @return void
     */
    public function settingsAction()
    {

        View::renderTemplate('Home/settings.html', [
            'user' => $this->user,
            'url' => 'settings'
        ]);
    }

    /**
     * Show the dalete page
     *
     * @return void
     */
    public function deleteAction()
    {

        if ($this->iot->delete($_GET['id'])) {

            Flash::addMessage('Deleted');

            $this->redirect('/iot/data');

        } else {

            Flash::addMessage('Oops something went wrong!');

            $this->redirect('/iot/data');

        }
    }

    /**
     * Show the dalete page
     *
     * @return void
     */
    public function deleteallAction()
    {

        if ($this->iot->deleteAll()) {

            Flash::addMessage('All data deleted');

            $this->redirect('/iot/data');

        } else {

            Flash::addMessage('Oops something went wrong!', Flash::WARNING);

            $this->redirect('/iot/data');

        }
    }
}