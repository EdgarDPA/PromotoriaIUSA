<template>
    <fusioncharts
    :type="type"
    :width="width"
    :height="height"
    :dataFormat="dataFormat"
    :dataSource="dataSource"
    ></fusioncharts>               
</template>

<script>
    import Vue from 'vue';
    import VueFusionCharts from 'vue-fusioncharts';
    import FusionCharts from 'fusioncharts';
    import Column2D from 'fusioncharts/fusioncharts.charts';
    import FusionTheme from 'fusioncharts/themes/fusioncharts.theme.fusion';

    Vue.use(VueFusionCharts, FusionCharts, Column2D, FusionTheme);

    const dataSource = {
    chart: {
      //caption: "Analysing Subsidies by Youth Population",
      //subcaption: "By province",
      yaxisname: "Oportunidades / Prospectos",
      syaxisname: "Oportunidades",
      labeldisplay: "rotate",
      //snumbersuffix: "%",
      scrollheight: "10",
      numvisibleplot: "12",
      drawcrossline: "1",
      exportenabled: "1",
      theme: "fusion"
    },
    categories: [
      {
        category: [
          {
            label: "Ene"
          },
          {
            label: "Feb"
          },
          {
            label: "Mar"
          },
          {
            label: "Abr"
          },
          {
            label: "May"
          },
          {
            label: "Jun"
          },
          {
            label: "Jul"
          },
          {
            label: "Ago"
          },
          {
            label: "Sep"
          },
          {
            label: "Oct"
          },
          {
            label: "Nov"
          },
          {
            label: "Dic"
          }
        ]
      }
    ],
    dataset: [
      {
        seriesname: "Oportunidades visitadas",
        plottooltext: "Oportunidades visitadas: $dataValue",
        data: [
          {
            value: "100"
          },
          {
            value: "120"
          },
          {
            value: "70"
          },
          {
            value: "100"
          },
          {
            value: "90"
          },
          {
            value: "90"
          },
          {
            value: "70"
          },
          {
            value: "50"
          },
          {
            value: "120"
          },
          {
            value: "90"
          },
          {
            value: "100"
          },
          {
            value: "90"
          }
        ]
      },
      {
        seriesname: "Prospectos",
        renderas: "area",
        showanchors: "0",
        plottooltext: "Prospectos: $dataValue",
        data: [
          {
            value: "50"
          },
          {
            value: "70"
          },
          {
            value: "50"
          },
          {
            value: "90"
          },
          {
            value: "70"
          },
          {
            value: "50"
          },
          {
            value: "60"
          },
          {
            value: "40"
          },
          {
            value: "90"
          },
          {
            value: "80"
          },
          {
            value: "80"
          },
          {
            value: "70"
          }
        ]
      },
      {
        seriesname: "Oportunidades",
        parentyaxis: "S",
        renderas: "line",
        plottooltext: "Oportunidades: $dataValue",
        showvalues: "0",
        data: [
          {
            value: "120"
          },
          {
            value: "150"
          },
          {
            value: "100"
          },
          {
            value: "90"
          },
          {
            value: "120"
          },
          {
            value: "100"
          },
          {
            value: "110"
          },
          {
            value: "80"
          },
          {
            value: "150"
          },
          {
            value: "100"
          },
          {
            value: "120"
          },
          {
            value: "110"
          }
        ]
      }
    ]
  };
  export default {
  components: {
  },
  data: () => ({
      type: "mscombi2d",
      width: "80%",
      height: "80%",
      dataFormat: "json",
      dataSource
  })
  };
</script>