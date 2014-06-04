<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public $cacheQueries = TRUE;
    public $recursive = 1;

    /**
   * Connects to specified database
   *
   * @param String name of different database to connect with.
   * @param String name of existing datasource
   * @return boolean true on success, false on failure
   * @access public
   */
    public function setDatabase($database, $datasource = 'default')
    {
        $nds = $datasource . '_' . $database;
        $db  = &ConnectionManager::getDataSource($datasource);

        $db->setConfig(array(
            'name'       => $nds,
            'database'   => $database,
            'persistent' => false
        ));

        if ( $ds = ConnectionManager::create($nds, $db->config) ) {
            $this->useDbConfig  = $nds;
            $this->cacheQueries = false;
            return true;
        }

        return false;
    }

    public function formatPhone($phone){
        // return preg_replace('/^(\+84|0)(\d{3,3}).*(\d{3,3})$/', '0$2.....$3', $phone);
        return preg_replace('/^(\+84|0)(.*)(\d)$/', '0$2x', $phone);
    }
}
