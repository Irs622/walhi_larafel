document.addEventListener('DOMContentLoaded', () => {
	const root = document.documentElement;
	const canvasWidth = 1470;

	const syncCanvasScale = () => {
		const scale = Math.min(1, window.innerWidth / canvasWidth);
		root.style.setProperty('--canvas-scale', String(scale));
	};

	syncCanvasScale();
	window.addEventListener('resize', syncCanvasScale);

	const toggle = document.querySelector('[data-mobile-menu-button]');
	const panel = document.querySelector('[data-mobile-menu-panel]');

	if (!toggle || !panel) {
		return;
	}

	const closePanel = () => {
		panel.classList.add('hidden');
		toggle.setAttribute('aria-expanded', 'false');
	};

	toggle.addEventListener('click', () => {
		const isHidden = panel.classList.contains('hidden');

		if (isHidden) {
			panel.classList.remove('hidden');
			toggle.setAttribute('aria-expanded', 'true');
			return;
		}

		closePanel();
	});

	panel.querySelectorAll('a').forEach((link) => {
		link.addEventListener('click', closePanel);
	});
});
