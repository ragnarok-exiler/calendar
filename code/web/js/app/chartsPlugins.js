//Create the plug in
var oLineDraw = Chart.controllers.horizontalBar.prototype.draw;
Chart.helpers.extend(Chart.controllers.horizontalBar.prototype, {

    draw: function () {
        oLineDraw.apply(this, arguments);

        var chart = this.chart;
        var ctx = chart.chart.ctx;

        var goals = chart.config.options.Goals;

        var xaxis = chart.scales['x-axis-0'];
        var yaxis = chart.scales['y-axis-0'];

        if (goals) {
            var color = 'red';
            var label = '';

            if (chart.config.options.GoalsColor) {
                color = chart.config.options.GoalsColor;
            }

            var x1 = xaxis.getPixelForValue(goals);
            var y1 = yaxis.top;

            var x2 = xaxis.getPixelForValue(goals);
            var y2 = yaxis.bottom;

            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.strokeStyle = color;
            ctx.lineTo(x2, y2);
            ctx.stroke();

            if (chart.config.options.GoalsLabel) {
                label = chart.config.options.GoalsLabel;
                var labelColor = 'grey';
                if (chart.config.options.GoalsLabelColor) {
                    labelColor = chart.config.options.GoalsLabelColor;
                }
                ctx.textAlign = 'left';
                ctx.fillStyle = labelColor;
                ctx.fillText(label, x1 + 5, y1 + 5);
            }
            ctx.restore();
        }


    }
});