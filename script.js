let hamburgerMenu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

hamburgerMenu.addEventListener('click',function() {
	let nav = document.querySelector('.navbar');
	nav.classList.toggle('active');
})
userBtn.addEventListener('click',function(){
	let userBox = document.querySelector('.user-box');
	userBox.classList.toggle('active');
})

//close form

const closeBtn = document.querySelector('#close-edit');

closeBtn.addEventListener('click',()=>{
	document.querySelector('.update-container').style.display='none';
})
