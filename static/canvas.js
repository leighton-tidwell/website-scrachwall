/* 
 * Scrach Wall Canvas
 * Writen by: Mark Ross <mark.ross@whitehatdev.com> 
 * Copyright (c) Whitehatdev.com 2014
 */

/* Depends on:
 *	- jquery.js
 */

var sw_canvas;
var sw_can_ctx;
var sw_can_height;
var sw_can_width;

var sw_previousX;
var sw_previousY;
var sw_X;
var sw_Y;
var sw_in = false;
var sw_coordinates;

var sw_colour;
var sw_brush;

function sw_save()
{
	var dataURL= sw_canvas.toDataURL();
	$.ajax(
		{
			type: "POST",
			url: "uploadcanvas.php",
			data: { file: dataURL }
		}
	).done(
		function(result)
		{
		}
	);
}

function sw_draw()
{
	sw_can_ctx.beginPath();
    sw_can_ctx.strokeStyle = sw_colour;
    sw_can_ctx.moveTo(sw_previousX, sw_previousY);
    sw_can_ctx.lineTo(sw_X, sw_Y);
    sw_can_ctx.lineWidth = sw_brush;
    sw_can_ctx.stroke();
    sw_can_ctx.closePath();
    sw_coordinates.push({x:sw_X, y:sw_Y});
}

function sw_action(act, e)
{
	switch(act)
	{
		case 0:
		{
			sw_in = true;
			sw_previousX = sw_X;
			sw_previousY = sw_Y;
	        sw_X = e.clientX - sw_canvas.offsetLeft;
	        sw_Y = e.clientY - sw_canvas.offsetTop;
	        sw_can_ctx.beginPath();
	        sw_can_ctx.fillStyle = sw_colour;
	        sw_can_ctx.fillRect(sw_X, sw_Y, 2, 2);
	        sw_can_ctx.closePath();
	        sw_coordinates.push({"x":sw_X, "y":sw_Y});
			break;
		}
		case 1:
		{
			if(sw_in)
			{
				sw_previousX = sw_X;
				sw_previousY = sw_Y;
		        sw_X = e.clientX - sw_canvas.offsetLeft;
		        sw_Y = e.clientY - sw_canvas.offsetTop;
	            sw_draw();
	        }
			break;
		}
		case 2:
		case 3:
		{
			sw_in = false;
			break;
		}
		default:
		{
			alert("An error occured.");
			break;
		}
	}
}

function sw_canvas_init()
{
	sw_canvas = $("#swcanvas")[0];
	sw_can_ctx = sw_canvas.getContext("2d");
	sw_can_height = $("#swcanvas").height();
	sw_can_width = $("#swcanvas").width();
	
	sw_coordinates = [];
	
	sw_brush = 2;
	sw_colour = "black";
	
	sw_canvas.addEventListener("mousemove", function(e) { sw_action(1, e); }, false);
	sw_canvas.addEventListener("mousedown", function(e) { sw_action(0, e); }, false);
	sw_canvas.addEventListener("mouseup", function(e) { sw_action(2, e); }, false);
	sw_canvas.addEventListener("mouseout", function(e) {sw_action(3, e); }, false);
	
	$("div#black").click(function() { sw_colour = "black"; });
	$("div#white").click(function() { sw_colour = "white"; });
	$("div#red").click(function() { sw_colour = "red"; });
	$("div#blue").click(function() { sw_colour = "blue"; });
	$("div#green").click(function() { sw_colour = "green"; });
}