// ✅ Activar item del menú lateral si existe
document.querySelectorAll('#sidebar .side-menu.top li a').forEach(item => {
	const li = item.parentElement;
	item.addEventListener('click', () => {
		document.querySelectorAll('#sidebar .side-menu.top li').forEach(li => li.classList.remove('active'));
		li.classList.add('active');
	});
});

// ✅ Toggle Sidebar (verifica que exista)
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

if (menuBar && sidebar) {
	menuBar.addEventListener('click', () => {
		sidebar.classList.toggle('hide');
	});
}

// ✅ Responsive Sidebar
function adjustSidebar() {
	if (!sidebar) return;
	if (window.innerWidth <= 576) {
		sidebar.classList.add('hide');
		sidebar.classList.remove('show');
	} else {
		sidebar.classList.remove('hide');
		sidebar.classList.add('show');
	}
}

window.addEventListener('load', adjustSidebar);
window.addEventListener('resize', adjustSidebar);

// ✅ Mostrar formulario de búsqueda en móviles
const searchButton = document.querySelector('#content nav form .form-input button');
const searchForm = document.querySelector('#content nav form');
const searchButtonIcon = searchButton?.querySelector('.bx');

if (searchButton && searchForm && searchButtonIcon) {
	searchButton.addEventListener('click', e => {
		if (window.innerWidth < 768) {
			e.preventDefault();
			searchForm.classList.toggle('show');
			searchButtonIcon.classList.toggle('bx-search');
			searchButtonIcon.classList.toggle('bx-x');
		}
	});
}

// ✅ Mostrar menús (con verificación)
const notificationBtn = document.querySelector('.notification');
const profileBtn = document.querySelector('.profile');
const notificationMenu = document.querySelector('.notification-menu');
const profileMenu = document.querySelector('.profile-menu');

if (notificationBtn && notificationMenu && profileMenu) {
	notificationBtn.addEventListener('click', () => {
		notificationMenu.classList.toggle('show');
		profileMenu.classList.remove('show');
	});

	profileBtn.addEventListener('click', () => {
		profileMenu.classList.toggle('show');
		notificationMenu.classList.remove('show');
	});

	// ✅ Cerrar menús al hacer clic fuera
	window.addEventListener('click', e => {
		if (!e.target.closest('.notification') && !e.target.closest('.profile')) {
			notificationMenu.classList.remove('show');
			profileMenu.classList.remove('show');
		}
	});
}

// ✅ Mostrar/Ocultar submenús (verificando existencia)
function toggleMenu(menuId) {
	const menu = document.getElementById(menuId);
	if (!menu) return;
	document.querySelectorAll('.menu').forEach(m => {
		if (m !== menu) m.style.display = 'none';
	});
	menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// ✅ Ocultar todos los submenús al cargar
document.addEventListener("DOMContentLoaded", () => {
	document.querySelectorAll('.menu').forEach(menu => {
		menu.style.display = 'none';
	});
});
