// MathMatch page behavior: toggle between menu and full-screen game view
document.addEventListener('DOMContentLoaded', function () {
	const playBtn = document.getElementById('playBtn');
	const backBtn = document.getElementById('backBtn');
	const menu = document.getElementById('menuScreen');
	const game = document.getElementById('gameScreen');

	// game elements
	const currentNumberEl = document.getElementById('currentNumber');
	const stepsLeftEl = document.getElementById('stepsLeft');
	const ballEl = document.getElementById('ball');
	const goalModal = document.getElementById('goalModal');
	const playAgainBtn = document.getElementById('playAgainBtn');
	const zonesEl = document.getElementById('zones');
	const zoneEls = zonesEl ? Array.from(zonesEl.querySelectorAll('.zone')) : [];

	let initialSteps = 0;
	let remainingSteps = 0;
	let currentNumber = 1;
	let zoneOptions = []; // array of maps {factor: count}
	let currentZoneIndex = 0;


	function showGame() {
		if (menu) menu.classList.add('hidden');
		if (game) game.classList.remove('hidden');
		// prevent scrolling behind
		document.documentElement.style.overflow = 'hidden';
		startRound();
	}

	function showMenu() {
		if (game) game.classList.add('hidden');
		if (menu) menu.classList.remove('hidden');
		document.documentElement.style.overflow = '';
	}

	if (playBtn) playBtn.addEventListener('click', showGame);
	if (backBtn) backBtn.addEventListener('click', showMenu);
	if (playAgainBtn) playAgainBtn.addEventListener('click', function(){
		goalModal.classList.add('hidden');
		startRound();
	});


	// ----------------- Game logic -----------------
	function startRound() {
		// generate a random number between 60 and 999 (favor composites)
		currentNumber = generateComposite(60, 999);
		const factors = primeFactors(currentNumber); // list with multiplicity
		initialSteps = factors.length;
		remainingSteps = initialSteps;
		// distribute factors across 6 zones
		zoneOptions = buildZoneOptions(factors, 6);
		currentZoneIndex = firstZoneWithOptions(zoneOptions);
		renderState();
		renderZone(currentZoneIndex);
		placeBallAtZone(currentZoneIndex);
		// hide modal
		if (goalModal) goalModal.classList.add('hidden');
	}

	function renderState() {
		if (currentNumberEl) currentNumberEl.textContent = currentNumber;
		if (stepsLeftEl) stepsLeftEl.textContent = remainingSteps;
	}

	// Render options for the given zone index
	function renderZone(zoneIndex) {
		zoneEls.forEach((z, i) => {
			const container = z.querySelector('.zone-buttons');
			container.innerHTML = '';
			if (i !== zoneIndex) return; // only render current zone
			const map = zoneOptions[i] || {};
			// build cards array so we can shuffle correct + distractors
			const cards = [];
			Object.keys(map).forEach(k => {
				const count = map[k];
				if (count <= 0) return;
				for (let m=0;m<count;m++) {
					const card = document.createElement('div');
					card.className = 'defense';
					card.dataset.factor = k;
					card.dataset.zone = i;
					const img = document.createElement('img');
					img.src = '/img/Defensa_MathMatch.png';
					img.alt = 'Defensa';
					const number = document.createElement('div');
					number.className = 'back-number';
					number.textContent = k;
					card.appendChild(img);
					card.appendChild(number);
					card.addEventListener('click', onZoneCardClick);
					cards.push(card);
				}
			});
			// add more distractor cards to increase difficulty
			const distractors = generateDistractors(Object.keys(map).map(x=>parseInt(x,10)), 3, 5);
			distractors.forEach(d => {
				const card = document.createElement('div');
				card.className = 'defense';
				card.dataset.factor = d;
				card.dataset.zone = i;
				const img = document.createElement('img');
				img.src = '/img/Defensa_MathMatch.png';
				img.alt = 'Defensa';
				const number = document.createElement('div');
				number.className = 'back-number';
				number.textContent = d;
				card.appendChild(img);
				card.appendChild(number);
				card.addEventListener('click', onZoneCardClick);
				cards.push(card);
			});
			// ensure we show at most 4 players per zone and keep at least the correct ones when possible
			const correctCards = cards.filter(c => Object.keys(map).includes(c.dataset.factor));
			const distractorCards = cards.filter(c => !Object.keys(map).includes(c.dataset.factor));

			// shuffle helper
			function shuffleArray(arr) {
				for (let s = arr.length - 1; s > 0; s--) {
					const r = Math.floor(Math.random() * (s + 1));
					const tmp = arr[s]; arr[s] = arr[r]; arr[r] = tmp;
				}
			}

			shuffleArray(correctCards);
			shuffleArray(distractorCards);

			const toShow = [];
			// include up to 4 correct cards (but if there are more than 4, limit to 4)
			for (let ci = 0; ci < Math.min(4, correctCards.length); ci++) toShow.push(correctCards[ci]);
			// if we still have slots, fill with distractors
			let di = 0;
			while (toShow.length < 4 && di < distractorCards.length) {
				toShow.push(distractorCards[di++]);
			}
			// if there were no correct cards (edge case), ensure at least one correct appears if available
			if (toShow.length > 0 && !toShow.some(c => Object.keys(map).includes(c.dataset.factor)) && correctCards.length > 0) {
				// replace a random slot with a correct card
				const idx = Math.floor(Math.random() * toShow.length);
				toShow[idx] = correctCards[0];
			}

			shuffleArray(toShow);
			toShow.forEach(c => container.appendChild(c));
		});
	}

	function onZoneCardClick(e) {
		const card = e.currentTarget;
		const f = parseInt(card.dataset.factor, 10);
		const z = parseInt(card.dataset.zone, 10);
		if (currentNumber % f !== 0) {
			// wrong
			card.classList.add('wrong');
			setTimeout(()=>card.classList.remove('wrong'), 400);
			return;
		}
		// correct
		currentNumber = Math.floor(currentNumber / f);
		remainingSteps -= 1;
		// decrement count in zoneOptions for this zone if present
		if (zoneOptions[z] && zoneOptions[z][f]) {
			zoneOptions[z][f] -= 1;
			if (zoneOptions[z][f] <= 0) delete zoneOptions[z][f];
		}
		renderState();
		// update the zone (if still has correct answers, re-render same zone), else advance
		const stillInZone = zoneHasCorrect(zoneOptions, z);
		if (currentNumber === 1) {
			setTimeout(()=> goalModal.classList.remove('hidden'), 350);
			placeBallAtZone(5); // move to goal end
			return;
		}
		if (stillInZone) {
			renderZone(z);
			placeBallAtZone(z);
		} else {
			const next = nextZoneWithOptions(zoneOptions, z+1);
			if (next !== -1) {
				currentZoneIndex = next;
				renderZone(currentZoneIndex);
				placeBallAtZone(currentZoneIndex);
			} else {
				// no more assigned zones but number >1 (rare) -> recompute distribution
				const remainingFactors = primeFactors(currentNumber);
				zoneOptions = buildZoneOptions(remainingFactors, 6);
				currentZoneIndex = firstZoneWithOptions(zoneOptions);
				renderZone(currentZoneIndex);
				placeBallAtZone(currentZoneIndex);
			}
		}
	}

	function placeBallAtProgress(progress) {
		// progress is 0..1, map to left percent between 6% and 86%
		const min = 6;
		const max = 86;
		const pct = min + (max - min) * Math.min(1, Math.max(0, progress));
		if (ballEl) ballEl.style.left = pct + '%';
	}

	function placeBallAtZone(zoneIndex) {
		// map zone index 0..5 to left percent along field between min and max
		const min = 6; const max = 86;
		const pct = min + (max - min) * (zoneIndex / 5);
		if (ballEl) ballEl.style.left = pct + '%';
	}

	function generateComposite(min, max) {
		// try until composite found, but avoid infinite loops
		for (let i=0;i<200;i++) {
			const n = Math.floor(Math.random()*(max-min+1))+min;
			if (!isPrime(n)) return n;
		}
		return 360; // fallback
	}

	function isPrime(n) {
		if (n < 2) return false;
		if (n % 2 === 0) return n === 2;
		const r = Math.floor(Math.sqrt(n));
		for (let i = 3; i <= r; i += 2) if (n % i === 0) return false;
		return true;
	}

	function primeFactors(n) {
		const res = [];
		let num = n;
		for (let p = 2; p * p <= num; p++) {
			while (num % p === 0) {
				res.push(p);
				num = Math.floor(num / p);
			}
		}
		if (num > 1) res.push(num);
		return res;
	}

	// Build zoneOptions: distribute factors across `zonesCount` zones.
	function buildZoneOptions(factorsArray, zonesCount) {
		const zones = Array.from({length: zonesCount}, ()=> ({}));
		// distribute by index mapping to spread factors across the field
		for (let i=0;i<factorsArray.length;i++) {
			const f = factorsArray[i];
			const zone = Math.min(zonesCount-1, Math.floor(i * zonesCount / factorsArray.length));
			zones[zone][f] = (zones[zone][f]||0) + 1;
		}
		return zones;
	}

	function firstZoneWithOptions(zones) {
		for (let i=0;i<zones.length;i++) if (zoneHasCorrect(zones, i)) return i;
		return 0;
	}

	function nextZoneWithOptions(zones, start) {
		for (let i=start;i<zones.length;i++) if (zoneHasCorrect(zones, i)) return i;
		return -1;
	}

	function zoneHasCorrect(zones, idx) {
		const map = zones[idx]||{};
		return Object.keys(map).length > 0;
	}

	function generateDistractors(excludeList, minCount, maxCount) {
		const primes = [2,3,5,7,11,13,17,19,23,29,31,37,41,43,47];
		const possibles = primes.filter(p=>!excludeList.includes(p));
		const n = Math.floor(Math.random()*(maxCount-minCount+1))+minCount;
		const out = [];
		for (let i=0;i<n && possibles.length>0;i++) {
			const idx = Math.floor(Math.random()*possibles.length);
			out.push(possibles.splice(idx,1)[0]);
		}
		return out;
	}
});
