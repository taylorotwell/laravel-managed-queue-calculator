<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel Cloud Managed Queues Pricing Calculator</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      color-scheme: light;
      --bg: #ffffff;
      --card: #ffffff;
      --text: #0a0a0a;
      --muted: #666666;
      --accent: #000000;
      --accent-dark: #000000;
      --border: #e5e5e5;
      --shadow: 0 24px 80px rgba(0, 0, 0, 0.06);
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: "Geist Mono", "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
      font-size: 14px;
      color: var(--text);
      background: var(--bg);
      display: grid;
      place-items: center;
      padding: 48px 18px;
    }

    main {
      width: min(100%, 980px);
    }

    .header {
      max-width: 960px;
      margin: 0 auto 28px;
      text-align: center;
    }

    .hero {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 20px;
      align-items: stretch;
    }

    .panel {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 24px;
      box-shadow: var(--shadow);
    }

    .calculator {
      padding: 32px;
    }

    h1 {
      margin: 0;
      font-size: clamp(1.65rem, 3.4vw, 2.9rem);
      line-height: 1;
      letter-spacing: -0.05em;
    }

    .intro {
      margin: 16px auto 0;
      max-width: 680px;
      color: var(--muted);
      font-size: 0.9rem;
      line-height: 1.65;
    }

    .control {
      padding: 22px 0;
      border-top: 1px solid var(--border);
    }

    .control:first-of-type {
      border-top: 0;
      padding-top: 0;
    }

    .control-header {
      display: flex;
      justify-content: space-between;
      gap: 16px;
      align-items: baseline;
      margin-bottom: 14px;
    }

    label {
      font-weight: 800;
      letter-spacing: -0.03em;
    }

    .value-input {
      font-family: inherit;
      font-size: inherit;
      font-weight: 700;
      font-variant-numeric: tabular-nums;
      color: var(--accent-dark);
      background: transparent;
      border: none;
      border-bottom: 1px solid transparent;
      text-align: right;
      width: 12ch;
      padding: 0;
      outline: none;
      transition: border-color 0.15s;
      -moz-appearance: textfield;
    }

    .value-input::-webkit-outer-spin-button,
    .value-input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .value-input:focus {
      border-bottom-color: var(--accent);
    }

    input[type="range"] {
      width: 100%;
      accent-color: var(--accent);
      cursor: pointer;
      appearance: none;
      background: transparent;
    }

    input[type="range"]::-webkit-slider-runnable-track {
      height: 6px;
      border: 0;
      border-radius: 999px;
      background: #e5e5e5;
    }

    input[type="range"]::-webkit-slider-thumb {
      width: 18px;
      height: 18px;
      margin-top: -6px;
      border: 2px solid #ffffff;
      border-radius: 999px;
      background: #000000;
      appearance: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.22);
    }

    input[type="range"]::-moz-range-track {
      height: 6px;
      border: 0;
      border-radius: 999px;
      background: #e5e5e5;
    }

    input[type="range"]::-moz-range-thumb {
      width: 18px;
      height: 18px;
      border: 2px solid #ffffff;
      border-radius: 999px;
      background: #000000;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.22);
    }

    .scale {
      display: flex;
      justify-content: space-between;
      margin-top: 8px;
      color: var(--muted);
      font-size: 0.74rem;
    }

    .assumptions {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
      margin-top: 10px;
    }

    .assumption {
      padding: 15px;
      border: 1px solid var(--border);
      border-radius: 16px;
      background: #fafafa;
    }

    .assumption span {
      display: block;
      color: var(--muted);
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.07em;
    }

    .assumption strong {
      display: block;
      margin-top: 5px;
      font-size: 0.95rem;
    }

    .results {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 28px;
      overflow: hidden;
      position: relative;
    }

    .results::before {
      content: "";
      position: absolute;
      display: none;
    }

    .price-card {
      position: relative;
      padding: 28px;
      border: 1px solid var(--border);
      border-radius: 20px;
      color: #000000;
      background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }

    .price-label {
      margin: 0 0 10px;
      opacity: 1;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      font-size: 0.68rem;
    }

    .price {
      margin: 0;
      font-size: clamp(1.75rem, 4.2vw, 3rem);
      line-height: 1;
      font-weight: 800;
      letter-spacing: -0.06em;
      overflow-wrap: anywhere;
    }

    .rate {
      margin: 16px 0 0;
      opacity: 1;
      line-height: 1.6;
    }

    .metrics {
      position: relative;
      display: grid;
      gap: 12px;
      margin-top: 18px;
    }

    .metric {
      display: flex;
      justify-content: space-between;
      gap: 14px;
      padding: 17px 0;
      border-bottom: 1px solid var(--border);
    }

    .metric:last-child {
      border-bottom: 0;
    }

    .metric span {
      color: var(--muted);
    }

    .metric strong {
      text-align: right;
      font-variant-numeric: tabular-nums;
    }

    .note {
      position: relative;
      margin: 24px 0 0;
      color: var(--muted);
      font-size: 0.8rem;
      line-height: 1.6;
    }

    @media (max-width: 800px) {
      .hero {
        grid-template-columns: 1fr;
      }

      .calculator,
      .results {
        padding: 24px;
      }

      .price {
        font-size: clamp(1.65rem, 9vw, 2.7rem);
      }
    }

    @media (max-width: 520px) {
      body {
        padding: 16px;
      }

      .assumptions {
        grid-template-columns: 1fr;
      }

      .control-header,
      .metric {
        align-items: flex-start;
        flex-direction: column;
      }

      .metric strong {
        text-align: left;
      }

      .price-card {
        padding: 22px;
      }

      .price {
        font-size: clamp(1.5rem, 10vw, 2.3rem);
      }
    }
  </style>
</head>
<body>
  <main>
    <header class="header">
      <h1 id="page-title">Managed Queues Pricing Calculator</h1>
      <p class="intro">
        Estimate monthly managed queue cost using job volume, average job duration, autoscaling worker count, compute time, and queue operations.
      </p>
    </header>

    <section class="hero" aria-labelledby="page-title">
      <div class="panel calculator">
        <div class="control">
          <div class="control-header">
            <label for="jobVolume">Job volume</label>
            <input id="jobVolumeNumber" class="value-input" type="number" min="1000" max="100000000" step="1000" value="100000" aria-label="Job volume per month">
          </div>
          <input id="jobVolume" type="range" min="1000" max="100000000" step="1000" value="100000">
          <div class="scale" aria-hidden="true">
            <span>1k jobs / mo</span>
            <span>100m jobs / mo</span>
          </div>
        </div>

        <div class="control">
          <div class="control-header">
            <label for="jobDuration">Average job duration</label>
            <input id="jobDurationNumber" class="value-input" type="number" min="1" max="300" step="1" value="5" aria-label="Average job duration in seconds">
          </div>
          <input id="jobDuration" type="range" min="1" max="300" step="1" value="5">
          <div class="scale" aria-hidden="true">
            <span>1 sec</span>
            <span>300 sec</span>
          </div>
        </div>

        <div class="control">
          <div class="control-header">
            <label for="workerCount">Autoscaled workers</label>
            <input id="workerCountNumber" class="value-input" type="number" min="1" max="25" step="1" value="10" aria-label="Maximum autoscaled worker count">
          </div>
          <input id="workerCount" type="range" min="1" max="25" step="1" value="10">
          <div class="scale" aria-hidden="true">
            <span>1 worker</span>
            <span>25 workers</span>
          </div>
        </div>

        <div class="control">
          <div class="control-header">
            <label for="pollingInterval">Polling interval</label>
            <input id="pollingIntervalNumber" class="value-input" type="number" min="1" max="60" step="1" value="10" aria-label="Queue polling interval in seconds">
          </div>
          <input id="pollingInterval" type="range" min="1" max="60" step="1" value="10">
          <div class="scale" aria-hidden="true">
            <span>1 sec</span>
            <span>60 sec</span>
          </div>
        </div>

        <div class="assumptions" aria-label="Static pricing assumptions">
          <div class="assumption">
            <span>Compute size</span>
            <strong>256MB instance</strong>
          </div>
          <div class="assumption">
            <span>Scale down window</span>
            <strong>~60 seconds</strong>
          </div>
          <div class="assumption">
            <span>Queue operations</span>
            <strong>$1 / million</strong>
          </div>
        </div>
      </div>

      <aside class="panel results" aria-label="Estimated pricing results">
        <div class="price-card">
          <p class="price-label">Estimated monthly cost</p>
          <p class="price" id="monthlyCost">$1.11</p>
          <p class="rate">Includes 256MB worker compute and queue operations.</p>
        </div>

        <div class="metrics">
          <div class="metric">
            <span>Compute cost</span>
            <strong id="computeCost">$0.76</strong>
          </div>
          <div class="metric">
            <span>Queue operation cost</span>
            <strong id="operationCost">$0.35</strong>
          </div>
          <div class="metric">
            <span>Estimated jobs processed</span>
            <strong id="processedJobs">100,000 jobs</strong>
          </div>
          <div class="metric">
            <span>Billed runtime worker seconds</span>
            <strong id="runtimeWorkerSeconds">500,000</strong>
          </div>
          <div class="metric">
            <span>Estimated queue operations</span>
            <strong id="queueOperations">350,060 ops</strong>
          </div>
        </div>

        <p class="note">
          This calculator estimates a 30-day month. If the selected workers cannot process all submitted jobs in that period, compute cost is capped by saturated worker capacity and unprocessed jobs are not counted as received or deleted.
        </p>
      </aside>
    </section>
  </main>

  <script>
    const WORKER_SECOND_RATE = 0.00000152;
    const QUEUE_OPERATION_RATE = 1 / 1000000;
    const SCALE_DOWN_SECONDS = 60;
    const SECONDS_PER_MONTH = 30 * 24 * 60 * 60;

    const jobVolume = document.querySelector('#jobVolume');
    const jobDuration = document.querySelector('#jobDuration');
    const workerCount = document.querySelector('#workerCount');
    const pollingInterval = document.querySelector('#pollingInterval');
    const jobVolumeNumber = document.querySelector('#jobVolumeNumber');
    const jobDurationNumber = document.querySelector('#jobDurationNumber');
    const workerCountNumber = document.querySelector('#workerCountNumber');
    const pollingIntervalNumber = document.querySelector('#pollingIntervalNumber');
    const monthlyCost = document.querySelector('#monthlyCost');
    const computeCost = document.querySelector('#computeCost');
    const operationCost = document.querySelector('#operationCost');
    const processedJobs = document.querySelector('#processedJobs');
    const runtimeWorkerSeconds = document.querySelector('#runtimeWorkerSeconds');
    const queueOperations = document.querySelector('#queueOperations');

    const numberFormatter = new Intl.NumberFormat('en-US');
    const currencyFormatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    function clamp(value, min, max) {
      return Math.min(Math.max(value, min), max);
    }

    function syncPair(slider, numberInput) {
      slider.addEventListener('input', () => {
        numberInput.value = slider.value;
        updateCalculator();
      });

      numberInput.addEventListener('input', () => {
        const raw = Number(numberInput.value);
        if (!Number.isFinite(raw)) return;
        const step = Number(slider.step);
        const val = clamp(Math.round(raw / step) * step, Number(slider.min), Number(slider.max));
        slider.value = val;
        updateCalculator();
      });

      numberInput.addEventListener('blur', () => {
        numberInput.value = slider.value;
      });
    }

    function updateCalculator() {
      const volume = Number(jobVolume.value);
      const duration = Number(jobDuration.value);
      const workers = Number(workerCount.value);
      const pollingIntervalSeconds = Number(pollingInterval.value);
      const requestedRuntimeSeconds = volume * duration;
      const monthlyCapacitySeconds = workers * SECONDS_PER_MONTH;
      const runtimeSeconds = Math.min(requestedRuntimeSeconds, monthlyCapacitySeconds);
      const completedJobs = Math.min(volume, Math.floor(runtimeSeconds / duration));
      const queueClears = completedJobs === volume;
      const scaleDownSeconds = queueClears ? workers * SCALE_DOWN_SECONDS : 0;
      const totalSeconds = runtimeSeconds + scaleDownSeconds;
      const compute = totalSeconds * WORKER_SECOND_RATE;
      const elapsedSeconds = runtimeSeconds / workers;
      const pollingSeconds = elapsedSeconds + (queueClears ? SCALE_DOWN_SECONDS : 0);
      const polls = Math.ceil(pollingSeconds / pollingIntervalSeconds) * workers;
      const operations = volume + (completedJobs * 2) + polls;
      const queueCost = operations * QUEUE_OPERATION_RATE;
      const cost = compute + queueCost;

      monthlyCost.textContent = currencyFormatter.format(cost);
      computeCost.textContent = currencyFormatter.format(compute);
      operationCost.textContent = currencyFormatter.format(queueCost);
      processedJobs.textContent = `${numberFormatter.format(completedJobs)} jobs`;
      runtimeWorkerSeconds.textContent = numberFormatter.format(runtimeSeconds);
      queueOperations.textContent = `${numberFormatter.format(operations)} ops`;
    }

    syncPair(jobVolume, jobVolumeNumber);
    syncPair(jobDuration, jobDurationNumber);
    syncPair(workerCount, workerCountNumber);
    syncPair(pollingInterval, pollingIntervalNumber);
    updateCalculator();
  </script>
</body>
</html>
