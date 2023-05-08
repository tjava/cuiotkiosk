<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */
class Iot extends \Core\Model
{

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Save data
     *
     * @return boolean  True if the data was saved, false otherwise
     */
    public function save($data)
    {
        $unique_id = $data['unique_id'];
        $current1 = $data['current1'];
        $current2 = $data['current2'];
        $current3 = $data['current3'];
        $battery = $data['battery'];


        if ($data) {

            $sql = 'INSERT INTO iot (unique_id, current1, current2, current3, battery)
                    VALUES (:unique_id, :current1, :current2, :current3, :battery)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);
            $stmt->bindValue(':current1', $current1, PDO::PARAM_STR);
            $stmt->bindValue(':current2', $current2, PDO::PARAM_STR);
            $stmt->bindValue(':current3', $current3, PDO::PARAM_STR);
            $stmt->bindValue(':battery', $battery, PDO::PARAM_STR);

            return $stmt->execute();

            
        }

        return false;
    }
    
    /**
     * Save data
     *
     * @return boolean  True if the data was saved, false otherwise
     */
    public function updateSwitch($unique_id, $switch)
    {
        $sql = 'UPDATE iot
            SET switch = :switch
            WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);
        $stmt->bindValue(':switch', $switch, PDO::PARAM_STR);

        return $stmt->execute();
        
    }
    
    /**
     * Save data
     *
     * @return boolean  True if the data was saved, false otherwise
     */
    public function changeSwitch($switch, $value)
    {
        $sql = 'UPDATE switchs
            SET '.$switch.' = :value
            WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':unique_id', 32120, PDO::PARAM_INT);
        $stmt->bindValue(':value', $value, PDO::PARAM_INT);

        return $stmt->execute();
        
    }
    
    /**
     * Save data
     *
     * @return boolean  True if the data was saved, false otherwise
     */
    public function changeAllSwitch($value)
    {
        $sql = 'UPDATE switchs
            SET switch1 = :value,
            switch2 = :value,
            switch3 = :value,
            switch4 = :value,
            switch5 = :value,
            switch6 = :value,
            switch7 = :value,
            switch8 = :value,
            switch9 = :value,
            switch10 = :value,
            switch11 = :value,
            switch12 = :value,
            switch13 = :value,
            switch14 = :value,
            switch15 = :value,
            switch16 = :value,
            switch17 = :value,
            switch18 = :value,
            switch19 = :value,
            switch20 = :value
            WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':unique_id', 32120, PDO::PARAM_INT);
        $stmt->bindValue(':value', $value, PDO::PARAM_INT);

        return $stmt->execute();
        
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function data($unique_id)
    {
        $sql = 'SELECT * FROM switchs WHERE unique_id = :unique_id ORDER BY id DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function Current1($unique_id)
    {
        $sql = 'SELECT current1 FROM iot WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_COLUMN);
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function Current2($unique_id)
    {
        $sql = 'SELECT current2 FROM iot WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_COLUMN);
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function Current3($unique_id)
    {
        $sql = 'SELECT current3 FROM iot WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_COLUMN);
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function Battery($unique_id)
    {
        $sql = 'SELECT battery FROM iot WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_COLUMN);
    }

    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function time($unique_id)
    {
        $sql = 'SELECT time FROM iot WHERE unique_id = :unique_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_COLUMN);
    }
    
    /**
     * show all
     *
     * @param string 
     *
     * @return mixed 
     */
    public function switches($unique_id)
    {
        $sql = 'SELECT switch FROM iot WHERE unique_id = :unique_id LIMIT 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->bindValue(':unique_id', $unique_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Delete 
     *
     * @param string 
     *
     * @return mixed 
     */
    public function delete($id)
    {

        $sql = 'DELETE FROM iot WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $stmt->execute();
    }

    /**
     * Delete 
     *
     * @param string 
     *
     * @return mixed 
     */
    public function deleteAll()
    {

        $sql = 'DELETE FROM iot';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $stmt->execute();
    }


}