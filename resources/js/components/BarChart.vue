<script>
import { Bar } from "vue-chartjs";

export default {
  props: ["vendasmensal"],
  extends: Bar,

  data() {
    return {};
  },
  created() {
    for (let i = 1; i <= 12; i++) {
      const isMonth = this.vendasmensal.find((venda, index) => {
        return venda.mes == i;
      });
      if (!isMonth) this.vendasmensal.push({ mes: i, total_factura: 0 });
    }
    //order mês
    this.vendasmensal.sort(function (a, b) {
      return a.mes - b.mes;
    });
  },
  methods: {},
  mounted() {
    var dynamicColors = function () {
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      return "rgb(" + r + "," + g + "," + b + ")";
    };

    const datasets = [
      {
        label: "Vendas Mensal - " + new Date().getFullYear(),
        backgroundColor: dynamicColors,
        data: [],
        options: {
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
                gridLines: {
                  display: true,
                },
              },
            ],
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
                gridLines: {
                  display: false,
                },
              },
            ],
          },
          legend: {
            display: false,
          },
          tooltips: {
            enabled: true,
            mode: "single",
            callbacks: {
              label: function (tooltipItems, data) {
                return  tooltipItems.yLabel;
              },
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          height: 200,
        },
      },
    ];

    this.vendasmensal.forEach((value) => {
      datasets[0].data.push(value.total_factura);
    });

    this.renderChart(
      {
        labels: [
          "Janeiro",
          "Fevereiro",
          "Março",
          "Abril",
          "Maio",
          "Junho",
          "Julho",
          "Agosto",
          "Setembro",
          "Outubro",
          "Novembro",
          "Dezembro",
        ],
        datasets,
      },
      {
        responsive: true,
        maintainAspectRatio: false,
      }
    );
  },
};
</script>
