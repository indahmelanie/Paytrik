var btnMenu = document.getElementsByClassName('btn-menu')[0];

btnMenu.onclick = function(){
	var icon2 = document.getElementsByClassName('icon2')[0];
	icon2.classList.toggle('action');
	var icon3 = document.getElementsByClassName('icon3')[0];
	icon3.classList.toggle('action');

	var lcontainer = document.getElementsByClassName('lcontainer')[0];
	lcontainer.classList.toggle('action');
	var rcontainer = document.getElementsByClassName('rcontainer')[0];
	rcontainer.classList.toggle('action');
	var logout = document.getElementsByClassName('logout')[0];
	logout.classList.toggle('xwidth');
}

var btnLogout = document.getElementsByClassName('btn-logout')[0];

btnLogout.onclick = function(){
	var screenLogout = document.getElementsByClassName('screen-logout')[0];
	screenLogout.classList.add('action');

	var logout = document.getElementsByClassName('logout')[0];
	logout.classList.add('action');
}

var closeLogout = document.getElementsByClassName('close-logout')[0];

closeLogout.onclick = function(){
	var screenLogout = document.getElementsByClassName('screen-logout')[0];
	screenLogout.classList.remove('action');

	var logout = document.getElementsByClassName('logout')[0];
	logout.classList.remove('action');
}

var screenLogout = document.getElementsByClassName('screen-logout')[0];

screenLogout.onclick = function(){
	this.classList.remove('action');

	var logout = document.getElementsByClassName('logout')[0];
	logout.classList.remove('action');
}