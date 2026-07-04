document.addEventListener('DOMContentLoaded', () => {
	const root = document.documentElement;
	const canvasWidth = 1470;

	const syncCanvasScale = () => {
		const scale = Math.min(1, window.innerWidth / canvasWidth);
		root.style.setProperty('--canvas-scale', String(scale));
	};

	syncCanvasScale();
	window.addEventListener('resize', syncCanvasScale);

	const filterButtons = Array.from(document.querySelectorAll('[data-blog-filter]'));
	const filterCards = Array.from(document.querySelectorAll('[data-blog-card]'));

	if (filterButtons.length > 0 && filterCards.length > 0) {
		const setButtonState = (button, active) => {
			button.style.backgroundColor = active ? '#256D4A' : '#F4F1EA';
			button.style.borderColor = active ? '#256D4A' : '#1D1D1D';
			button.style.color = active ? '#F4F1EA' : '#1D1D1D';
		};

		const applyFilter = (category) => {
			filterButtons.forEach((button) => {
				setButtonState(button, button.dataset.blogFilter === category);
			});

			filterCards.forEach((card) => {
				const matches = category === 'Semua' || card.dataset.blogCategory === category;
				card.hidden = !matches;
			});
		};

		filterButtons.forEach((button) => {
			button.addEventListener('click', () => applyFilter(button.dataset.blogFilter || 'Semua'));
		});

		applyFilter('Semua');
	}

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
