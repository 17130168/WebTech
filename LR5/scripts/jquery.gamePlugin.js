 (function ($) {
      	var duckMethods = {
      		init: function (direction, flySec, attitude, onDuckFlyAway, onDuckKilled) {
      
      			// настройки, будут индивидуальными при каждом запуске
      			var settings = $.extend({}, direction);
      			settings.direction = direction
      			settings.isDead = false
      			settings.flySec = flySec
      			settings.attitude = attitude * 0.3
      			settings.onDuckFlyAway = onDuckFlyAway
      			settings.onDuckKilled = onDuckKilled
      			
      			if (!this.data('duckPlugin')) {
      				this.data('duckPlugin', settings);
      
      				$(this).css("transition", "transform " + settings.flySec + "s linear");
      				
      				// стартовая позиция и анимация
      				if (settings.direction) {
      					$(this).css("animation-name", "move");
      					$(this).css("transform", "translate(-10vw," + settings.attitude + "vh)");						
      				}
      				else {
      					$(this).css("animation-name", "move-reverse");
      					$(this).css("transform", "translate(60vw," + settings.attitude + "vh)");
      				}
      				
      				this.on('click.duckPlugin', function () {
      					// Утка подстрелена
      					if (settings.isDead == false) {
      						settings.onDuckKilled()
      						settings.isDead = true
      						
      						$(this).css("animation-play-state", "paused");
      						if (settings.direction) {
      							$(this).css("transition", "transform " + settings.flySec  / 2 + "s linear");
      							$(this).css("transform", "translate(45vw,60vh) rotate(450deg)");
      						}
      						else {
      							$(this).css("transition", "transform " + settings.flySec / 2 + "s linear");
      							$(this).css("transform", "translate(10vw,60vh) rotate(450deg)");
      						}
      						// Утка упала
      						setTimeout(() => $(this).duckPlugin("remove"), settings.flySec / 2 * 1000);
      						
      					}
      				});
      			}
      			return this;
      		},
      
      		fly: function () {
      			var settings = $(this).data('duckPlugin');
      			$(this).css("transition", "transform  "+ settings.flySec + "s linear");
      			$(this).css("animation-play-state", "running");
      			if (settings.direction) {
      				$(this).css("transform", "translate(60vw," + settings.attitude + "vh)");
      
      			} else {
      				$(this).css("transform", "translate(-10vw," + settings.attitude + "vh)");
      			}
      			// Утка улетела
      			setTimeout(() => {
      				if (!settings.isDead)
      				{
      					$(this).duckPlugin("remove")
      					settings.onDuckFlyAway()
      				}
      			}, settings.flySec * 1000);
      		},
      		
      		remove:  function () {
      			$(this).remove()
      		}
      
      	};
      
      	$.fn.duckPlugin = function (method) {
      		if (duckMethods[method]) {
      			return duckMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      		} else if (typeof method === 'object' || !method) {
      			return duckMethods.init.apply(this, arguments);
      		} else {
      			$.error('Метод "' + method + '" в плагине не найден');
      		}
      	};
      	
      })(jQuery);
      
      (function ($) {
	  
	    var duckKilledCount = 0
		var duckFlyAwayCount = 0
		
      	function getRandomInt(max) {
      		return Math.floor(Math.random() * max);
      	}
      
      	var gameMethods = {
      		start:  function () {
      				$(this).gamePlugin("createNewDuck")
      				$(this).gamePlugin("createNewDuck")
      				$(this).gamePlugin("createNewDuck")
      			},
      		createNewDuck: function () {
      			var duck = $('<div class="duck"></div>')
      			$(this).append(duck);
      			duck.duckPlugin("init", getRandomInt(2), 2 + getRandomInt(5), getRandomInt(101), () => $(this).gamePlugin("duckFlyAway"), () => $(this).gamePlugin("duckHasBeenKilled"));
      			setTimeout(() => duck.duckPlugin("fly"), 600);
      		},
      			
      		duckFlyAway: function () {
      				duckFlyAwayCount++
      				$('#ducks-fly-away-count').text("Упущенно: " + duckFlyAwayCount);
      				$(this).gamePlugin("createNewDuck")
      		},
      			
      		duckHasBeenKilled:	function(){
      				duckKilledCount++	
      				$('#ducks-killed-count').text("Убито: " + duckKilledCount);
      				$(this).gamePlugin("createNewDuck")		
      			}
      	}
      	
      	$.fn.gamePlugin = function (method) {
      		if (gameMethods[method]) {
      			return gameMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      		} else if (typeof method === 'object' || !method) {
      			return gameMethods.init.apply(this, arguments);
      		} else {
      			$.error('Метод "' + method + '" в плагине не найден');
      		}
      	};
      })(jQuery);
      
