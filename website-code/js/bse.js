$(document).ready(function go(){
  $.ajax({
    url : "http://boscoempresarios2018.com/bse.php",
    type : "GET",
    success : function(data){
      console.log(data);

      var id = [];
      var indice = [];
      var time = [];    
      var max=0;

      for(var i in data) {
        //id.push("id " + data[i].id);
        id.push(data[i].id);
        indice.push(data[i].indice);
        time.push(data[i].time);   
        if(data[i].indice>max)
         max=data[i].indice;
      }

      var chartdata = {
        labels: time,
        datasets: [
          {
            label: "Stock Index",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(254, 151, 26, 0.75)",
            borderColor: "rgba(254, 151, 26, 1)",
            pointHoverBackgroundColor: "rgba(254, 151, 26, 1)",
            pointHoverBorderColor: "rgba(254, 151, 26, 1)",
            data: indice
          }
        ]
      };

      Chart.defaults.LineWithLine = Chart.defaults.line;
      Chart.controllers.LineWithLine = Chart.controllers.line.extend({
      	draw: function(ease) {
      		Chart.controllers.line.prototype.draw.call(this, ease);

      		if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
      			var activePoint = this.chart.tooltip._active[0],
      			ctx = this.chart.ctx,
             	x = activePoint.tooltipPosition().x,
             	topY = this.chart.scales['y-axis-0'].top,
             	bottomY = this.chart.scales['y-axis-0'].bottom;

         		// draw line
         		ctx.save();
         		ctx.beginPath();
         		ctx.moveTo(x, topY);
         		ctx.lineTo(x, bottomY);
         		ctx.lineWidth = 2;
         		ctx.strokeStyle = "rgb(196,122,32,0.75)";
         		ctx.stroke();
        		ctx.restore();
      		}
  		 }
	  });

      var ctx = $("#mycanvas");

      var LineGraph = new Chart(ctx, {
        type: 'LineWithLine',
        data: chartdata,        
        options: {
            legend: {
            	labels: {
                	fontColor: "white"
            	}
        	},
        	scales: {
        		xAxes: [{
                  	ticks: {
                    	fontColor: "#1d1d1d"                    	
                	},
        			gridLines: {
        				color: "#000"
        			}
        		}],
            	yAxes: [{
                  	ticks: {
                    	fontColor: "white",
                    	min:8000,
                    	suggestedMax:max
                	},
            		gridLines: {
            			color: "#000000"
            		},
                	stacked: true
            	}]
        	},
        	tooltips: {
         		intersect: false
      		},
        	elements: {
            	line: {
                	tension: 0, // disables bezier curves
            	},
              point: {
                radius: 0
              }
        	}
    	}
      });
    },
    error : function(data) {

    }
  })
});