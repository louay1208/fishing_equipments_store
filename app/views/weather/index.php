<!-- Hero Header -->
<div class="page-header" style="background: linear-gradient(165deg, #0c2440 0%, #0b1a2b 45%, #162c46 100%); padding: 2.5rem 0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 style="color:#e2e8f0;"><span style="font-size:1.5rem;vertical-align:middle;">🌤️</span> Météo Marine</h1>
                <p style="color:#7dd3fc; margin:0.3rem 0 0;">Conditions en temps réel sur les côtes tunisiennes — <span id="cityCount">0</span> spots</p>
            </div>
            <div class="text-end">
                <div style="color:#94a3b8; font-size:0.8rem;">Dernière mise à jour</div>
                <div style="color:#e2e8f0; font-weight:600;" id="weatherTime">Chargement...</div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">

    <!-- Best Spot Banner -->
    <div class="weather-best-spot reveal" id="bestSpotBanner" style="display:none;">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="weather-best-icon">🎯</div>
            <div>
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); font-weight:600;">Meilleur spot aujourd'hui</div>
                <div style="font-size:1.2rem; font-weight:700; color:var(--ocean);" id="bestSpotName"></div>
            </div>
            <div class="ms-auto text-center">
                <div class="weather-score-ring" id="bestSpotRing">
                    <span id="bestSpotScore"></span>
                </div>
                <div style="font-size:0.72rem; color:var(--text-muted); margin-top:4px;">Score pêche</div>
            </div>
        </div>
    </div>

    <!-- Region Filter Tabs -->
    <div class="weather-region-tabs mt-3 reveal" id="regionTabs" style="display:none;">
        <button class="weather-region-btn active" data-region="all">
            🗺️ Tous les spots
        </button>
    </div>

    <!-- Loading State -->
    <div id="weatherLoading" class="text-center py-5">
        <div class="spinner-border" style="color:var(--sea); width:3rem; height:3rem;" role="status"></div>
        <p class="text-muted mt-3">Récupération des données météo pour toute la côte tunisienne...</p>
        <div class="weather-load-progress">
            <div class="weather-load-bar" id="loadBar"></div>
        </div>
        <p class="text-muted mt-2" style="font-size:0.8rem;" id="loadStatus">0 / 0 villes chargées</p>
    </div>

    <!-- Weather Cards Grid -->
    <div class="row g-3 mt-2" id="weatherGrid" style="display:none;"></div>

    <!-- Legend -->
    <div class="card p-4 mt-4 reveal" id="weatherLegend" style="display:none; background:var(--bg-card); border-color:var(--border-light); color:var(--text-primary);">
        <h6 class="fw-bold mb-3" style="color:var(--ocean);"><i class="bi bi-info-circle me-2"></i>Comment lire le score de pêche ?</h6>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:12px;height:12px;border-radius:50%;background:#22c55e;flex-shrink:0;"></span>
                    <div>
                        <div class="fw-semibold" style="font-size:0.85rem; color:var(--text-primary);">80-100 : Excellentes</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">Conditions idéales, foncez !</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:12px;height:12px;border-radius:50%;background:#0ea5e9;flex-shrink:0;"></span>
                    <div>
                        <div class="fw-semibold" style="font-size:0.85rem; color:var(--text-primary);">60-79 : Bonnes</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">Sortie recommandée</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:12px;height:12px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></span>
                    <div>
                        <div class="fw-semibold" style="font-size:0.85rem; color:var(--text-primary);">40-59 : Moyennes</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">Pêche possible, prudence</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:12px;height:12px;border-radius:50%;background:#ef4444;flex-shrink:0;"></span>
                    <div>
                        <div class="fw-semibold" style="font-size:0.85rem; color:var(--text-primary);">0-39 : Défavorables</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">Restez à terre</div>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-color:var(--border-light);margin:1rem 0;">
        <div class="d-flex flex-wrap gap-3 align-items-center" style="font-size:0.78rem; color:var(--text-muted);">
            <span><i class="bi bi-lightning-charge me-1"></i>Score basé sur : température, vent, vagues, météo</span>
            <span><i class="bi bi-arrow-repeat me-1"></i>Données actualisées à chaque visite</span>
            <span><i class="bi bi-globe2 me-1"></i>Source : <a href="https://open-meteo.com/" target="_blank" rel="noopener">Open-Meteo</a></span>
        </div>
    </div>
</div>

<script>
(function() {
    const CITIES = [
        // Nord
        { name: 'Bizerte',   lat: 37.27, lon:  9.87, icon: '⚓', region: 'Nord',   desc: 'Port de pêche' },
        { name: 'Tabarka',   lat: 36.95, lon:  8.76, icon: '🪸', region: 'Nord',   desc: 'Côte corallienne' },
        // Cap Bon
        { name: 'Kélibia',   lat: 36.85, lon: 11.10, icon: '🐟', region: 'Cap Bon', desc: 'Port de pêche' },
        { name: 'Hammamet',  lat: 36.40, lon: 10.62, icon: '🏖️', region: 'Cap Bon', desc: 'Station balnéaire' },
        // Sahel
        { name: 'Sousse',    lat: 35.83, lon: 10.59, icon: '🌊', region: 'Sahel',  desc: 'Perle du Sahel' },
        { name: 'Mahdia',    lat: 35.50, lon: 11.06, icon: '🐠', region: 'Sahel',  desc: 'Capitale de la pêche' },
        // Sud
        { name: 'Gabès',     lat: 33.88, lon: 10.10, icon: '🌴', region: 'Sud',    desc: 'Golfe de Gabès' },
        { name: 'Djerba',    lat: 33.80, lon: 10.85, icon: '☀️',  region: 'Sud',    desc: 'Île des rêves' },
    ];

    const REGION_ICONS = {
        'Nord': '🧭', 'Cap Bon': '🍊', 'Sahel': '⛵', 'Sud': '🌴'
    };

    const WEATHER_CODES = {
        0:  { label: 'Ciel dégagé',         icon: '☀️' },
        1:  { label: 'Principalement dégagé', icon: '🌤️' },
        2:  { label: 'Partiellement nuageux', icon: '⛅' },
        3:  { label: 'Couvert',              icon: '☁️' },
        45: { label: 'Brouillard',           icon: '🌫️' },
        48: { label: 'Brouillard givrant',   icon: '🌫️' },
        51: { label: 'Bruine légère',        icon: '🌦️' },
        53: { label: 'Bruine modérée',       icon: '🌦️' },
        55: { label: 'Bruine dense',         icon: '🌧️' },
        61: { label: 'Pluie légère',         icon: '🌧️' },
        63: { label: 'Pluie modérée',        icon: '🌧️' },
        65: { label: 'Pluie forte',          icon: '🌧️' },
        80: { label: 'Averses légères',      icon: '🌦️' },
        81: { label: 'Averses modérées',     icon: '🌧️' },
        82: { label: 'Averses violentes',    icon: '⛈️' },
        95: { label: 'Orage',               icon: '⛈️' },
        96: { label: 'Orage avec grêle',     icon: '⛈️' },
        99: { label: 'Orage violent',        icon: '⛈️' },
    };

    function calcScore(temp, wind, wave, code) {
        let s = 70;
        if (temp !== null) {
            if (temp >= 18 && temp <= 26) s += 15;
            else if (temp >= 14 && temp <= 30) s += 5;
            else s -= 15;
        }
        if (wind !== null) {
            if (wind < 10) s += 10;
            else if (wind < 20) s += 5;
            else if (wind < 35) s -= 10;
            else s -= 25;
        }
        if (wave !== null) {
            if (wave < 0.5) s += 10;
            else if (wave < 1.0) s += 5;
            else if (wave < 2.0) s -= 10;
            else s -= 20;
        }
        if (code <= 2) s += 5;
        else if (code >= 95) s -= 30;
        else if (code >= 61) s -= 15;
        return Math.max(0, Math.min(100, s));
    }

    function getColor(score) {
        if (score >= 80) return '#22c55e';
        if (score >= 60) return '#0ea5e9';
        if (score >= 40) return '#f59e0b';
        return '#ef4444';
    }
    function getLabel(score) {
        if (score >= 80) return 'Excellentes';
        if (score >= 60) return 'Bonnes';
        if (score >= 40) return 'Moyennes';
        return 'Défavorables';
    }
    function getCheckIcon(score) {
        if (score >= 60) return 'check-circle-fill';
        if (score >= 40) return 'dash-circle';
        return 'x-circle-fill';
    }

    function renderCard(w, i) {
        const color = getColor(w.score);
        const label = getLabel(w.score);
        const icon = getCheckIcon(w.score);
        return `
        <div class="col-sm-6 col-lg-4 col-xl-3 weather-card-col" data-region="${w.region}" style="animation: fadeInUp 0.4s ${i * 0.04}s ease both;">
            <div class="weather-card">
                <div class="weather-card-header">
                    <div>
                        <span class="weather-city-icon">${w.cityIcon}</span>
                        <span class="weather-city-name">${w.city}</span>
                    </div>
                    <span class="weather-condition-icon">${w.weatherIcon}</span>
                </div>
                <div class="weather-card-sub">${w.desc} · <span style="color:var(--sea);">${w.region}</span></div>

                <div class="weather-temp">
                    ${w.temp !== null ? w.temp.toFixed(1) : '—'}<span class="weather-temp-unit">°C</span>
                </div>
                <div class="weather-condition">${w.weatherLabel}</div>

                <div class="weather-metrics">
                    <div class="weather-metric">
                        <i class="bi bi-wind"></i>
                        <div>
                            <div class="weather-metric-value">${w.wind !== null ? Math.round(w.wind) : '—'} <small>km/h</small></div>
                            <div class="weather-metric-label">Vent</div>
                        </div>
                    </div>
                    <div class="weather-metric">
                        <i class="bi bi-water"></i>
                        <div>
                            <div class="weather-metric-value">${w.wave !== null ? w.wave.toFixed(1) : '—'} <small>m</small></div>
                            <div class="weather-metric-label">Vagues</div>
                        </div>
                    </div>
                    <div class="weather-metric">
                        <i class="bi bi-droplet"></i>
                        <div>
                            <div class="weather-metric-value">${w.humidity !== null ? w.humidity : '—'}<small>%</small></div>
                            <div class="weather-metric-label">Humidité</div>
                        </div>
                    </div>
                    <div class="weather-metric">
                        <i class="bi bi-clock-history"></i>
                        <div>
                            <div class="weather-metric-value">${w.wavePeriod !== null ? w.wavePeriod.toFixed(1) : '—'} <small>s</small></div>
                            <div class="weather-metric-label">Période</div>
                        </div>
                    </div>
                </div>

                <div class="weather-fishing-score">
                    <div class="weather-fishing-bar">
                        <div class="weather-fishing-fill" style="width:${w.score}%; background:${color};"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="weather-fishing-label" style="color:${color};">
                            <i class="bi bi-${icon}"></i>
                            ${label}
                        </span>
                        <span class="weather-fishing-num" style="color:${color};">${w.score}/100</span>
                    </div>
                </div>
            </div>
        </div>`;
    }

    async function fetchCityWeather(city) {
        const [weatherResp, marineResp] = await Promise.all([
            fetch(`https://api.open-meteo.com/v1/forecast?latitude=${city.lat}&longitude=${city.lon}&current=temperature_2m,wind_speed_10m,weather_code,relative_humidity_2m&timezone=Africa/Tunis`),
            fetch(`https://marine-api.open-meteo.com/v1/marine?latitude=${city.lat}&longitude=${city.lon}&current=wave_height,wave_period&timezone=Africa/Tunis`)
        ]);
        const weather = await weatherResp.json();
        const marine = await marineResp.json();

        const code = weather?.current?.weather_code ?? 0;
        const info = WEATHER_CODES[code] || WEATHER_CODES[0];

        const temp = weather?.current?.temperature_2m ?? null;
        const wind = weather?.current?.wind_speed_10m ?? null;
        const humidity = weather?.current?.relative_humidity_2m ?? null;
        const wave = marine?.current?.wave_height ?? null;
        const wavePeriod = marine?.current?.wave_period ?? null;
        const score = calcScore(temp, wind, wave, code);

        return {
            city: city.name, cityIcon: city.icon, region: city.region, desc: city.desc,
            temp, wind, humidity, wave, wavePeriod,
            weatherLabel: info.label, weatherIcon: info.icon, score
        };
    }

    // Fetch in batches to avoid rate limiting
    async function fetchAllInBatches(cities, batchSize = 5) {
        const results = [];
        const loadBar = document.getElementById('loadBar');
        const loadStatus = document.getElementById('loadStatus');
        const total = cities.length;

        for (let i = 0; i < cities.length; i += batchSize) {
            const batch = cities.slice(i, i + batchSize);
            const batchResults = await Promise.all(batch.map(c => fetchCityWeather(c)));
            results.push(...batchResults);

            const done = Math.min(i + batchSize, total);
            const pct = (done / total * 100).toFixed(0);
            if (loadBar) loadBar.style.width = pct + '%';
            if (loadStatus) loadStatus.textContent = `${done} / ${total} spots chargés`;
        }
        return results;
    }

    function setupRegionFilter(results) {
        const regions = [...new Set(results.map(r => r.region))];
        const tabsContainer = document.getElementById('regionTabs');
        const grid = document.getElementById('weatherGrid');

        // Add region buttons
        regions.forEach(region => {
            const count = results.filter(r => r.region === region).length;
            const btn = document.createElement('button');
            btn.className = 'weather-region-btn';
            btn.dataset.region = region;
            btn.innerHTML = `${REGION_ICONS[region] || '📍'} ${region} <span class="weather-region-count">${count}</span>`;
            tabsContainer.appendChild(btn);
        });

        // Click handler
        tabsContainer.addEventListener('click', e => {
            const btn = e.target.closest('.weather-region-btn');
            if (!btn) return;

            tabsContainer.querySelectorAll('.weather-region-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const region = btn.dataset.region;
            grid.querySelectorAll('.weather-card-col').forEach(col => {
                if (region === 'all' || col.dataset.region === region) {
                    col.style.display = '';
                    col.style.animation = 'fadeInUp 0.3s ease both';
                } else {
                    col.style.display = 'none';
                }
            });
        });

        tabsContainer.style.display = '';
    }

    async function init() {
        try {
            document.getElementById('cityCount').textContent = CITIES.length;
            const results = await fetchAllInBatches(CITIES, 5);

            // Sort by score descending
            results.sort((a, b) => b.score - a.score);

            // Update time
            const now = new Date();
            document.getElementById('weatherTime').textContent =
                now.toLocaleTimeString('fr-TN', {hour:'2-digit', minute:'2-digit'}) + ' — ' +
                now.toLocaleDateString('fr-TN');

            // Best spot
            const best = results[0];
            const banner = document.getElementById('bestSpotBanner');
            document.getElementById('bestSpotName').innerHTML =
                `${best.cityIcon} ${best.city} <span style="font-size:0.85rem; font-weight:500; color:var(--text-secondary);"> — ${best.weatherLabel}, ${best.temp?.toFixed(1)}°C, vagues ${best.wave?.toFixed(1)}m</span>`;
            const ring = document.getElementById('bestSpotRing');
            ring.style.setProperty('--score-color', getColor(best.score));
            ring.style.setProperty('--score-pct', best.score + '%');
            document.getElementById('bestSpotScore').textContent = best.score;
            banner.style.display = '';

            // Render cards
            const grid = document.getElementById('weatherGrid');
            grid.innerHTML = results.map((r, i) => renderCard(r, i)).join('');
            grid.style.display = '';

            // Setup region filter
            setupRegionFilter(results);

            // Show legend
            document.getElementById('weatherLegend').style.display = '';

            // Hide loader
            document.getElementById('weatherLoading').style.display = 'none';

        } catch (err) {
            console.error('Weather fetch error:', err);
            document.getElementById('weatherLoading').innerHTML =
                `<div class="empty-state">
                    <div class="icon">⚠️</div>
                    <h5 style="color:var(--ocean);">Impossible de charger les données</h5>
                    <p class="text-muted">Vérifiez votre connexion internet et rechargez la page.</p>
                    <button class="btn btn-primary" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Réessayer
                    </button>
                </div>`;
        }
    }

    init();
})();
</script>
