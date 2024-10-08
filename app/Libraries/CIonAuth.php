<?php namespace App\Libraries;

class CIonAuth extends \IonAuth\Libraries\IonAuth
{
    public function isSuperAdmin(int $id=0): bool
	{
		$this->ionAuthModel->triggerEvents('is_superadmin');

		$superAdminGroup = $this->config->superAdminGroup;

		return $this->loggedIn() && $this->ionAuthModel->inGroup($superAdminGroup, $id);
	}

    public function setSession($role): bool
	{

		if($role)
		{
			$sessionData = [
				'role_id'               => $role->id,
				'role_name'             => $role->name,
				'role_description'      => $role->description,
			];

			if(!$this->session->has('primary_user_id'))
			{
				$sessionData['primary_user_id'] = $this->session->get('user_id');
			}

			$this->session->set($sessionData);
		}

		return true;
	}

    public function logout(): bool
	{
		$this->ionAuthModel->triggerEvents('logout');

		$identity = $this->session->get('user_id');

		$this->session->remove([$identity, 'id', 'user_id']);

		// delete the remember me cookies if they exist
		delete_cookie($this->config->rememberCookieName);

		// Clear all codes
		if (isset($identity)) {
			$this->ionAuthModel->clearForgottenPasswordCode($identity);
			$this->ionAuthModel->clearRememberCode($identity);
		}

		// Destroy the session
		$this->session->destroy();

		// Recreate the session
		//session_start();

		//session_regenerate_id(true);

		$this->setMessage('IonAuth.logout_successful');
		return true;
	}
    
} 