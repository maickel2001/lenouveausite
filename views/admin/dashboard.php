<?php $config = $config ?? (require dirname(__DIR__, 2) . '/config/config.php'); ?>
<h1 class="h2">Tableau de bord</h1>
<div class="grid">
  <div class="tile"><div class="kpi">Pending<br><strong>0</strong></div></div>
  <div class="tile"><div class="kpi">Processing<br><strong>0</strong></div></div>
  <div class="tile"><div class="kpi">Completed<br><strong>0</strong></div></div>
  <div class="tile"><div class="kpi">Cancelled<br><strong>0</strong></div></div>
</div>
<div class="card mt-16">
  <canvas id="ordersChart" height="140"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ordersChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['M-5','M-4','M-3','M-2','M-1','M'],
    datasets: [{
      label: 'Commandes',
      data: [0,0,0,0,0,0],
      borderColor: getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
      tension: 0.3,
    }]
  },
  options: {plugins: {legend: {display: false}}, scales: {y: {beginAtZero: true}}}
});
</script>
