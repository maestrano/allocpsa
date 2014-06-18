<?php

/**
 * Configure App specific behavior for 
 * Maestrano SSO
 */
class MnoSsoUser extends MnoSsoBaseUser
{
  /**
   * Database connection
   * @var PDO
   */
  public $connection = null;
  
  
  /**
   * Extend constructor to inialize app specific objects
   *
   * @param OneLogin_Saml_Response $saml_response
   *   A SamlResponse object from Maestrano containing details
   *   about the user being authenticated
   */
  public function __construct(OneLogin_Saml_Response $saml_response, &$session = array(), $opts = array())
  {
    // Call Parent
    parent::__construct($saml_response,$session);
    
    // Assign new attributes
    $this->connection = $opts['db_connection'];
  }
  
  
  /**
   * Sign the user in the application. 
   * Parent method deals with putting the mno_uid, 
   * mno_session and mno_session_recheck in session.
   *
   * @return boolean whether the user was successfully set in session or not
   */
  protected function setInSession()
  {
    // Get the active user
    $this->connection->query("SELECT * FROM person WHERE personID = {$this->local_id} AND personActive = 1");
    $user = $this->connection->row();
    
    if ($user['personID']) {
        $sess = new session();
        $sess->Start($user);
        $sess->UseCookie();
        $sess->SetTestCookie($_POST["username"]);
        $sess->Save();
        
        return true;
    } else {
        return false;
    }
  }
  
  
  /**
   * Used by createLocalUserOrDenyAccess to create a local user 
   * based on the sso user.
   * If the method returns null then access is denied
   *
   * @return the ID of the user created, null otherwise
   */
  protected function createLocalUser()
  {
    $lid = null;
    
    if ($this->accessScope() == 'private') {
      $person = $this->buildLocalUser();
      
      // Create user
      $q = $person->save();
      $lid = $person->get_id();
    }
    
    return $lid;
  }
  
  /**
   * Helper method to build a local user
   *
   */
  protected function buildLocalUser()
  {
    $person = new person();
    $person->set_value("username", $this->uid);
    $person->set_value("perms", $this->getRoleValueToAssign());
    $person->set_value('password', encrypt_password($this->generatePassword()));
    $person->set_value("personActive", 1);
    
    $person->set_value("firstName", $this->name);
    $person->set_value("surname", $this->surname);
    $person->set_value("emailAddress", $this->email);
    $person->currency = config::get_config_item('currency');
    
    return $person;
  }
  
  /**
   * Create the role to give to the user based on context
   * If the user is the owner of the app or at least Admin
   * for each organization, then it is given the role of 'Admin'.
   * Return 'User' role otherwise
   *
   * @return the ID of the user created, null otherwise
   */
  public function getRoleValueToAssign() {
    $role_value = 'employee';
    
    if ($this->app_owner) {
      $role_value = 'god,admin,manage,employee';
    } else {
      foreach ($this->organizations as $organization) {
        if ($organization['role'] == 'Admin' || $organization['role'] == 'Super Admin') {
          $role_value = 'god,admin,manage,employee';
        } else {
          $role_value = 'employee';
        }
      }
    }
    
    return $role_value;
  }
  
  /**
   * Get the ID of a local user via Maestrano UID lookup
   *
   * @return a user ID if found, null otherwise
   */
  protected function getLocalIdByUid()
  {
    
    $this->connection->query("SELECT personID FROM person WHERE mno_uid = '{$this->uid}' LIMIT 1");
    $result = $this->connection->row();
    
    if ($result && $result['personID']) {
      return $result['personID'];
    }
    
    return null;
  }
  
  /**
   * Get the ID of a local user via email lookup
   *
   * @return a user ID if found, null otherwise
   */
  protected function getLocalIdByEmail()
  {
    $q = prepare("SELECT personID FROM person WHERE emailAddress = '%s' LIMIT 1", $this->email);
    $this->connection->query($q);
    $result = $this->connection->row();
    
    if ($result && $result['personID']) {
      return $result['personID'];
    }
    
    return null;
  }
  
  /**
   * Set all 'soft' details on the user (like name, surname, email)
   * Implementing this method is optional.
   *
   * @return boolean whether the user was synced or not
   */
   protected function syncLocalDetails()
   {
     if($this->local_id) {
       $q = prepare("UPDATE person SET firstName = '%s',
       surname = '%s',
       emailAddress = '%s'
       WHERE personID = $this->local_id", $this->name, $this->surname, $this->email);
       
       $upd = $this->connection->query($q);
       
       return $upd;
     }
     
     return false;
   }
  
  /**
   * Set the Maestrano UID on a local user via id lookup
   *
   * @return a user ID if found, null otherwise
   */
  protected function setLocalUid()
  {
    if($this->local_id) {
      $upd = $this->connection->query("UPDATE person SET mno_uid = '{$this->uid}' WHERE personID = {$this->local_id}");
      return $upd;
    }
    
    return false;
  }
}