<?php

class controlAdmincp
{
	public function index()
	{
		$controlName='admincp/controlDashboard';

		if(Session::has('userid'))
		{
			$valid=UserGroups::getPermission($_SESSION['groupid'],'can_view_admincp');

			if($valid!='yes')
			{
				Alert::make('You not have permission to view this page');
			}
			
			$controlName='admincp/controlDashboard';

			if($match=Uri::match('^admincp\/(\w+)'))
			{
				$controlName='admincp/control'.ucfirst($match[1]);
			}			
		}
		else
		{
			$controlName='admincp/controlLogin';

			if($match=Uri::match('^admincp\/forgotpass'))
			{
				$controlName='admincp/controlForgotpass';
			}			
		}

		Controller::load($controlName);
	}
}

?>