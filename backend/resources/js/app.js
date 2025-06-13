import './bootstrap';
import '../css/app.css';
import '../css/custom_tailwind.css';

// Funcionalidades básicas de la aplicación
document.addEventListener('DOMContentLoaded', function() {
	// Toggle para el menú de usuario
	const userMenuButton = document.getElementById('user-menu-button');
	const userMenu = document.getElementById('user-menu');

	if (userMenuButton && userMenu) {
		userMenuButton.addEventListener('click', function(e) {
			e.preventDefault();
			userMenu.classList.toggle('hidden');
		});

		// Cerrar menú al hacer click fuera
		document.addEventListener('click', function(e) {
			if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
				userMenu.classList.add('hidden');
			}
		});
	}

	// Auto-hide de mensajes de alerta
	const alerts = document.querySelectorAll('[role="alert"], .alert');
	alerts.forEach(alert => {
		setTimeout(() => {
			alert.style.transition = 'opacity 0.5s ease-out';
			alert.style.opacity = '0';
			setTimeout(() => {
				alert.remove();
			}, 500);
		}, 5000);
	});

	// Confirmación para acciones destructivas
	const deleteButtons = document.querySelectorAll('[data-confirm]');
	deleteButtons.forEach(button => {
		button.addEventListener('click', function(e) {
			const message = this.getAttribute('data-confirm') || '¿Estás seguro?';
			if (!confirm(message)) {
				e.preventDefault();
			}
		});
	});
});

// Funciones globales útiles
window.showNotification = function(message, type = 'info') {
	const notification = document.createElement('div');
	notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
		type === 'success' ? 'bg-green-500' :
			type === 'error' ? 'bg-red-500' :
				type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
	} text-white`;
	notification.textContent = message;

	document.body.appendChild(notification);

	setTimeout(() => {
		notification.remove();
	}, 5000);
};
