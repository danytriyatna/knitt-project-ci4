
<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
  <div class="container-fluid">
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $titlehead ?></h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./"><?= $name_app ?></a></li>
            <li class="breadcrumb-item active"><?= $titlehead ?></li>
          </ol>
        </div>
      </div>
    </div>
    
    <?= $this->include('App\Views\dashboard\partials\charts') ?>

  </div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
  <script>
    const barOption = {
      title: {
        text: 'ECharts Bar Example'
      },
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        }
      },
      legend: {
        top: 'bottom',
      },
      grid: {
        left: '3%',
        right: '4%',
        bottom: '12%',
        containLabel: true
      },
      xAxis: {
        type: 'category',
        data: ['2019', '2020', '2021', '2022', '2023', '2024'],
      },
      yAxis: {
        type: 'value',
        boundaryGap: [0, 0.01],
      },
      series: [
        {
          name: 'Series 1',
          type: 'bar',
          data: [18203, 23489, 29034, 104970, 131744, 630230]
        },
        {
          name: 'Series 2',
          type: 'bar',
          data: [19325, 23438, 31000, 121594, 134141, 681807]
        }
      ]
    };

    const pieOption = {
      title: {
        text: 'ECharts Doughnut Example',
        left: 'center'
      },
      tooltip: {
        trigger: 'item'
      },
      legend: {
        orient: 'vertical',
        left: 'left'
      },
      series: [{
        type: 'pie',
        bottom: '-10%',
        radius: ['40%', '70%'],
        label: {
          formatter: '{c}  {per|{d}%}',
          backgroundColor: '#F6F8FC',
          borderColor: '#8C8D8E',
          borderWidth: 1,
          borderRadius: 4,
          padding: [3, 4],
          rich: {
            per: {
              color: '#fff',
              backgroundColor: '#4C5058',
              padding: [3, 4],
              borderRadius: 4
            }
          }
        },
        data: [{
            value: 1263,
            name: 'Data 1',
            itemStyle: {color: '#35CE8D'},
          },
          {
            value: 606,
            name: 'Data 2',
            itemStyle: {color: '#8D0801'},
          },
        ],
        emphasis: {
          itemStyle: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        }
      }]
    };

    echarts_init("chart_bar", barOption);
    echarts_init("chart_pie", pieOption);
  </script>
<?= $this->endSection('script'); ?>