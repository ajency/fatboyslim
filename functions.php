<?php

function is_admin()
{
	if(!isset($_SESSION['is_admin']))
		return false;

	if((int)$_SESSION['is_admin'] === 1)
		return true;
	else
		return false;

}