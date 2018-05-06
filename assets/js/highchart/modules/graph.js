$(function () {
	Highcharts.setOptions({
		credits: {
			enabled: false
		},
		lang: {
			thousandsSep: "."
		}
	});

    $('#chart-1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Realisasi Dana Harian (30 Juli 2015)'
        },
        xAxis: {
        	categories: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
        	title: {
        		text: 'Group Corporate Banking'
        	}
        },
        yAxis: {
            // min: 0,
            title: {
                text: 'DKP (Rupiah)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>Rp {point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Total',
            data: [8160492, 11911794, 5548866, 7259901, 9169733, 22191043, 28448874]
        }, {
            name: 'Target',
            data: [7632452, 12313152, 5542311, 12313112, 6563563, 15112413, 27231131]
        }, {
            name: 'Selisih',
            data: [528040, -401358, 6555, -5053211, 2606170, 7078630, 1217743]
        }]
    });

	$('#chart-2').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Realisasi Dana Harian'
        },
       	tooltip: {
            pointFormat: '{series.name}: <b>Rp {point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Total',
            data: [
            	{ name: 'Group A', y: 8160492 },
            	{ name: 'Group B', y: 11911794 },
            	{ name: 'Group C', y: 5548866 },
            	{ name: 'Group D', y: 7259901 },
            	{ name: 'Group E', y: 9169733 },
            	{ name: 'Group F', y: 22191043 },
            	{ name: 'Group G', y: 28448874 }
            ]
        }]
    });

	$('#chart-3').highcharts({
        title: {
            text: 'Pertumbuhan Terbesar'
        },
        xAxis: {
        	categories: ['Petrokimia Gresik', 'Multimas Nabati', 'Adhi Karya', 'Pembangunan Perumahan', 'Wana Sawit Subur Lestari', 'Semen Baturaja', 'Maspion'],
        	title: {
        		text: 'Debitur'
        	}
        },
        yAxis: [{
        	opposite: true,
        	title: {
        		text: 'Pertumbuhan (Rupiah)'
        	}
        }, {
            min: 0,
            title: {
                text: 'DKP (Rupiah)'
            }
        }],
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>Rp {point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Juni 2015',
            type: 'column',
            yAxis: 1,
            data: [7632452, 12313152, 5542311, 12313112, 6563563, 15112413, 27231131]
        }, {
            name: 'Juli 2015',
            type: 'column',
            yAxis: 1,
            data: [8160492, 11911794, 5548866, 7259901, 9169733, 22191043, 28448874]
        }, {
            name: 'Pertumbuhan',
            type: 'line',
            data: [528040, -401358, 6555, -5053211, 2606170, 7078630, 1217743]
        }]
    });
});