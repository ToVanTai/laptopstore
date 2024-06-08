// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

//theme
const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if (this.checked) {
		document.body.classList.add('dark');
		localStorage.setItem("cacheTheme", JSON.stringify(true));
	} else {
		document.body.classList.remove('dark');
		localStorage.setItem("cacheTheme", JSON.stringify(false));
	}
});

(function(){
	let isDark = false;
	let cacheTheme = localStorage.getItem("cacheTheme");
	if(cacheTheme){
		isDark = JSON.parse(cacheTheme);
	}
	if(isDark){
		document.body.classList.add('dark');
	}else{
		document.body.classList.remove('dark');
	};
	const switchMode = document.getElementById('switch-mode');
	switchMode.checked = isDark;
})()