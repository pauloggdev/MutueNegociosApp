<script>
import { Bar } from "vue-chartjs";

export default {
  props: ["licencaativasmensal"],
  extends: Bar,

  data() {
    return {};
  },
  created() {

    console.log(this.licencaativasmensal);


    for (let i = 1; i <= 12; i++) {
      const isMonth = this.licencaativasmensal.find((licenca, index) => {
        return licenca.mes == i;
      });
      if (!isMonth) this.licencaativasmensal.push({ mes: i, total_licenca: 0 });
    }
    //order mês
    this.licencaativasmensal.sort(function (a, b) {
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
        label: "Activação licença Mensal - " + new Date().getFullYear(),
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

    this.licencaativasmensal.forEach((value) => {
      datasets[0].data.push(value.total_licenca);
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
          "Augosto",
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
