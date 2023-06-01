<x-admin-app-layout>
  <div class="relative pt-16 pb-32 bg-sky-500">
    <div class="px-4 md:px-6 mx-auto w-full">
      <div>
        <div class="flex flex-wrap">
          <x-admin.card
            title="Новые пользователи"
            :value="$newUsers['value']"
            icon_class="bi bi-people-fill"
            :difference="$newUsers['difference']"
            last="За прошлую неделю"
          />
        </div>
      </div>
    </div>
  </div>
  <div class="px-4 md:px-6 mx-auto w-full -mt-24">
    <div class="flex flex-wrap">
      <div class="w-full xl:w-8/12 px-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-blueGray-800">
          <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
            <div class="flex flex-wrap items-center">
              <div class="relative w-full max-w-full flex-grow flex-1">
                <h6 class="uppercase mb-1 text-xs font-semibold text-blueGray-200">Статистика</h6>
                <h2 class="text-xl font-semibold text-white">Продажи</h2>
              </div>
            </div>
          </div>
          <div class="p-4 flex-auto">
            <div class="relative h-[350px]">
              <canvas
                id="line-chart"
                width="500"
                height="350"
                style="display: block; box-sizing: border-box;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full xl:w-4/12 px-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-8 shadow-lg rounded-lg bg-white">
          <div class="rounded-t mb-0 px-4 pt-3 bg-transparent">
            <div class="flex flex-wrap items-center">
              <div class="relative w-full max-w-full flex-grow flex-1">
                <h6 class="uppercase mb-1 text-xs font-semibold text-blueGray-500">Заказы</h6>
                <h2 class="text-xl font-semibold text-blueGray-800">Последние заказы</h2>
              </div>
            </div>
          </div>
          <div class="px-2 py-4 flex-auto">
            <div class="relative h-[350px]">
              <ul class="divide-y divide-gray-200 h-full">
                @foreach ($lastOrders as $order)
                  <li class="p-3 sm:p-4">
                    <a href="{{ route('admin.order.show', ['order' => $order]) }}" class="flex items-center space-x-4">
                      <div class="flex-shrink-0"><span>#{{ $order->id }}</span></div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $order->user->email }}</p>
                      </div>
                      <div class="inline-flex items-center text-base font-semibold text-gray-900">
                        {!! number_format($order->priceBasket, 2, ',', '&nbsp;') !!}&nbsp;&#8381;
                      </div>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-admin-app-layout>

<script>
  (function () {
    const line_chart = document.getElementById('line-chart');

    const getOrCreateTooltip = (chart) => {
      let tooltipEl = chart.canvas.parentNode.querySelector('div');

      if (!tooltipEl) {
        tooltipEl = document.createElement('div');
        tooltipEl.style.background = 'rgba(0, 0, 0, 0.7)';
        tooltipEl.style.borderRadius = '3px';
        tooltipEl.style.color = 'white';
        tooltipEl.style.opacity = 1;
        tooltipEl.style.pointerEvents = 'none';
        tooltipEl.style.position = 'absolute';
        tooltipEl.style.transform = 'translate(-50%, 0)';
        tooltipEl.style.transition = 'all .1s ease';

        const table = document.createElement('table');
        table.style.margin = '0px';

        tooltipEl.appendChild(table);
        chart.canvas.parentNode.appendChild(tooltipEl);
      }

      return tooltipEl;
    };

    const externalTooltipHandler = (context) => {
      // Tooltip Element
      const {chart, tooltip} = context;
      const tooltipEl = getOrCreateTooltip(chart);

      // Hide if no tooltip
      if (tooltip.opacity === 0) {
        tooltipEl.style.opacity = 0;
        return;
      }

      // Set Text
      if (tooltip.body) {
        const titleLines = tooltip.title || [];
        const bodyLines = tooltip.body.map(b => b.lines);

        const tableHead = document.createElement('thead');

        titleLines.forEach(title => {
          const tr = document.createElement('tr');
          tr.style.borderWidth = 0;

          const th = document.createElement('th');
          th.style.borderWidth = 0;
          const text = document.createTextNode(title);

          th.appendChild(text);
          tr.appendChild(th);
          tableHead.appendChild(tr);
        });

        const tableBody = document.createElement('tbody');
        bodyLines.forEach((body, i) => {
          const colors = tooltip.labelColors[i];

          const span = document.createElement('span');
          span.style.background = colors.backgroundColor;
          span.style.borderColor = colors.borderColor;
          span.style.borderWidth = '2px';
          span.style.marginRight = '10px';
          span.style.height = '10px';
          span.style.width = '10px';
          span.style.display = 'inline-block';

          const tr = document.createElement('tr');
          tr.style.backgroundColor = 'inherit';
          tr.style.borderWidth = 0;

          const td = document.createElement('td');
          td.style.borderWidth = 0;

          const text = document.createTextNode(body);

          td.appendChild(span);
          td.appendChild(text);
          tr.appendChild(td);
          tableBody.appendChild(tr);
        });

        const tableRoot = tooltipEl.querySelector('table');

        // Remove old children
        while (tableRoot.firstChild) {
          tableRoot.firstChild.remove();
        }

        // Add new children
        tableRoot.appendChild(tableHead);
        tableRoot.appendChild(tableBody);
      }

      const {offsetLeft: positionX, offsetTop: positionY} = chart.canvas;

      // Display, position, and set styles for font
      tooltipEl.style.opacity = 1;
      tooltipEl.style.left = positionX + tooltip.caretX + 'px';
      tooltipEl.style.top = positionY + tooltip.caretY + 'px';
      tooltipEl.style.font = tooltip.options.bodyFont.string;
      tooltipEl.style.padding = tooltip.options.padding + 'px ' + tooltip.options.padding + 'px';
    };

    new Chart(line_chart, {
      type: 'bar',
      data: {
        labels: {{ Js::from($sale['datesSales']) }},
        datasets: [{
          label: 'Статистика',
          data: {{ Js::from($sale['valuesSales']) }},
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
          ],
          borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        animations: {
          radius: {
            duration: 400,
            easing: 'linear',
            loop: (context) => context.active
          }
        },
        interaction: {
          mode: 'nearest',
          axis: 'x',
          intersect: false,
        },
        plugins: {
          tooltip: {
            enabled: false,
            position: 'nearest',
            external: externalTooltipHandler
          },
          legend: {
            display: false
         }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      },
    });
  }());

</script>