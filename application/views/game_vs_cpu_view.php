
	<style type="text/css">
		@media (max-width: 768px) 
		{
			.titleOfPage
			{
				font-size: medium;
				font-weight: bold;
			}
			.messages 
			{
				font-size: small;
				text-align: center;
				
			}
			.matchup
			{
				font-size: small;
			}
			.turn
			{
				font-size: small;
				text-align: center;
				padding-top: 5px;
				padding-bottom: 5px;
			}
			table
			{
				table-layout: fixed;
				max-width: 300px;
				max-height: 200px;
			}

			td
			{
				width: 100px;
				height: 25%;
				font-size: large;
				text-align: center;
				border: 1px solid black;
			}
			th
			{
				text-align: center;
				border: 1px solid black;
			}
			.navbar
			{
				display: none;
			}
		}

		.takenAI
		{
			background-color: red;
		}

		.takenWinner
		{
			background-color: rgba(255, 215, 0, 0.3);
		}

		#theGrid
		{
			margin: auto;
			align-content: center;
			border: 1px solid black;
			table-layout: fixed;
			width: 500px;
			height: 400px;
		}

		.thinking 
		{
			text-align: center;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.messages 
		{
			text-align: center;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.turn
		{
			text-align: center;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.table-responsive
		{
			padding-top: 10px;
			padding-bottom: 10px;
		}

		td
		{
			height: 25%;
			text-align: center;
			border: 1px solid black;
		}
		th
		{
			width: 33%;
			height: 25%;
			text-align: center;
			border: 1px solid black;
		}
	</style>

		<div class = "container">
			<h2  class = "titleOfPage" align="center">Game Screen</h2>

			<!--Makes the data transferred from the controller readable-->
					<?php 
						if($games)
						{
							foreach($games as $name)
							{
							}
						}
					?>

			<h4 class = "matchup" align="center"><?php echo $name->player1name; ?> VS <?php echo $name->player2name; ?></h4>

			
				<div class = "messages"></div>
				<div class = "turn"></div>
				
					<table id="theGrid" class="table table-bordered table-striped table-responsive">
						<tr> 
							<td id = "grid1"></td>
							<td id = "grid2"></td>
							<td id = "grid3"></td>
						</tr>
						
						<tr>
							<td id = "grid4"></td>
							<td id = "grid5"></td>
							<td id = "grid6"></td>
						</tr>

						<tr>
							<td id = "grid7"></td>
							<td id = "grid8"></td>
							<td id = "grid9"></td>
						</tr>
					</table>

			<form action = "<?php echo base_url('MainContro/posting_results'); ?>" method = "post", class = "form-horizontal"  align="center">
				<input class = "player1name" type = "hidden" name = "player1name" id = "player1name" value = "<?php echo $name->player1name; ?>">
				<input class = "player2name" type = "hidden" name = "player2name" id = "player2name" value = "<?php echo $name->player2name; ?>">
				<input class = "winner" type = "hidden" name = "winner" id = "winner">

				<div class="row" style="margin: 50px">
					<div class="col-md-6">
						<a href="<?php echo base_url('MainContro/results'); ?>" class="btn btn-danger btn-lg">ยกเลิก</a>
					</div>
					<div class="col-md-6">
						<input class= "btn btn-success btn-lg" type="submit" value="บันทึก" />
					</div>
				</div>
				
			</form>

		</div>

<script>
	$(function()
	{
		
		var player1name = "<?php echo $name->player1name; ?>";
		var player2name = "<?php echo $name->player2name; ?>";
		var playerCurrent = player1name;
		var winner = $(".winner");
		var messages = $(".messages");
		var turn = $(".turn");
		var cnt = 0;
		var winCond;

		playerTurnNotification(playerCurrent, turn);
		$('td').click(function() 
		{
			cnt++;	
			td = $(this);
			var hasSymbol = getSymbolOnGrid(td);
			if(hasSymbol == 1 && winCond != 1)	
			{
				var playerSymbol = getCurrPlayerSymbol(playerCurrent, player1name);
				changeGridSymbol(td, playerSymbol);
				winCond = checkForVictory()
				if(winCond == 1)	
				{
					messages.html("Winner is " +playerCurrent+ "!!!");
					winner.html(playerCurrent);
					$("#winner").val(playerCurrent);
					turn.html("--- Game over ---");
				}
				else if(winCond == 0)
				{
					playerCurrent = setNextPlayer(playerCurrent, player1name, player2name);
					messages.html(" ");
					if(playerCurrent == player2name)	
					{
						if(cnt == 9 && winCond == 0)
						{
							messages.html("Game  Samoe Kan ");
							$("#winner").val("Samoe Kan");
							winner.html("Samoe Kan");
							turn.html("--- Game over ---");
						}
						else
						{
							var validTurn = aiPlayerStrategyChoice(playerCurrent, player1name);
							cnt++;
							winCond = checkForVictory()

							if(winCond == 1) 
							{
								messages.html("Winner is " +playerCurrent+ "  !!!");
								winner.html(playerCurrent);
								$("#winner").val(playerCurrent);
								turn.html("--- Game over ---");
							}

							else if(winCond == 0)	
							{
								playerCurrent = setNextPlayer(playerCurrent, player1name, player2name);
							}	
						}
					}
				}
			}
			else
			{
				if(winCond != 1)
				{
					
					messages.html("Box has already been checked");
					cnt--;
				}
			}
		});
	});

	
	function aiPlayerStrategyChoice(playerCurrent, player1name)
	{
		var aiPlay = null;
		rngAmountNeeded = 5;
		var rng = Math.floor((Math.random() * 10) + 1);
		
		if(rng > rngAmountNeeded)
		{
			aiPlay = aiWinOrPrevent();
		}

		rng = Math.floor((Math.random() * 10) + 1);
		if (aiPlay == null && rng > rngAmountNeeded)
		{
			aiPlay = aiPlayCenter();
		}

		rng = Math.floor((Math.random() * 10) + 1);
		if (aiPlay == null && rng > rngAmountNeeded)
		{
			aiPlay = aiPlayCorner();
		}

		rng = Math.floor((Math.random() * 10) + 1);		
		if (aiPlay == null && rng > rngAmountNeeded)
		{
			aiPlay = aiPlaySide();
		}

		if(aiPlay == null)
		{
			
			aiPlay = aiPlayerRandomTurn(playerCurrent, player1name);
		}
		
		return aiPlay;
	}

	
	function aiPlaySide()
	{
		var cellToPlace;
		var randomCorner = Math.floor((Math.random() * 4) + 1);
		
		if( randomCorner == 1 && !$("#grid2").hasClass("taken") )
		{
			cellToPlace = $("#grid2");
			changeGridSymbol(cellToPlace, 2);
		}

		else if( randomCorner == 2 && !$("#grid4").hasClass("taken") )
		{
			cellToPlace = $("#grid4");
			changeGridSymbol(cellToPlace, 2);
		}

		else if( randomCorner == 3 && !$("#grid6").hasClass("taken") )
		{
			cellToPlace = $("#grid6");
			changeGridSymbol(cellToPlace, 2);
		}

		else if( randomCorner == 4 && !$("#grid8").hasClass("taken") )
		{
			cellToPlace = $("#grid8");
			changeGridSymbol(cellToPlace, 2);
		}

		else
		{
			cellToPlace = null;
		}
		
		return cellToPlace;
	}

	function aiPlayCorner()
	{
		var cellToPlace;
		var randomCorner = Math.floor((Math.random() * 4) + 1);
		
		if( randomCorner == 1 && !$("#grid1").hasClass("taken") )
		{
			cellToPlace = $("#grid1");
			changeGridSymbol(cellToPlace, 2);
		}

		else if( randomCorner == 2 && !$("#grid3").hasClass("taken") )
		{
			cellToPlace = $("#grid3");
			changeGridSymbol(cellToPlace, 2);
		}

		else if( randomCorner == 3 && !$("#grid7").hasClass("taken") )
		{
			cellToPlace = $("#grid7");
			changeGridSymbol(cellToPlace, 2);
		}

		else if( randomCorner == 4 && !$("#grid9").hasClass("taken") )
		{
			cellToPlace = $("#grid9");
			changeGridSymbol(cellToPlace, 2);
		}

		else
		{
			cellToPlace = null;
		}
		
		return cellToPlace;
	}

	function aiPlayCenter()
	{
		var cellToPlace;
		
		if( ($('#grid5').hasClass("taken") ))
		{
			cellToPlace = null;
		}
		else
		{
			cellToPlace = $('#grid5');
			changeGridSymbol(cellToPlace, 2);
			
		}
		
		return cellToPlace;
	}

	
	function aiWinOrPrevent()
	{
		var cellToPlace = null;
		var blockingPlace = 0;
		var possiblePlacings = [];
		var index = 0;
		var iterator = 0;
		
		
		if( ($("#grid1").html() == $("#grid2").html() && !$("#grid3").hasClass("taken")) && ($("#grid1").hasClass("taken") && $("#grid2").hasClass("taken")) )
		{
			possiblePlacings[index] = 3;
			index++;
			possiblePlacings[index] = $("#grid1").html();
			index++;
		}
		if( ($("#grid2").html() == $("#grid3").html() && !$("#grid1").hasClass("taken")) && ($("#grid2").hasClass("taken") && $("#grid3").hasClass("taken")) )
		{
			possiblePlacings[index] = 1;
			index++;
			possiblePlacings[index] = $("#grid2").html();
			index++;
		}
		if( ($("#grid1").html() == $("#grid3").html() && !$("#grid2").hasClass("taken")) && ($("#grid1").hasClass("taken") && $("#grid3").hasClass("taken")) )
		{
			possiblePlacings[index] = 2;
			index++;
			possiblePlacings[index] = $("#grid1").html();
			index++;
		}

	
		if( ($("#grid4").html() == $("#grid5").html() && !$("#grid6").hasClass("taken")) && ($("#grid4").hasClass("taken") && $("#grid5").hasClass("taken")) )
		{
			possiblePlacings[index] = 6;
			index++;
			possiblePlacings[index] = $("#grid4").html();
			index++;
		}
		if( ($("#grid5").html() == $("#grid6").html() && !$("#grid4").hasClass("taken")) && ($("#grid5").hasClass("taken") && $("#grid6").hasClass("taken")) )
		{
			possiblePlacings[index] = 4;
			index++;
			possiblePlacings[index] = $("#grid5").html();
			index++;
		}
		if( ($("#grid6").html() == $("#grid4").html() && !$("#grid5").hasClass("taken")) && ($("#grid6").hasClass("taken") && $("#grid4").hasClass("taken")) )
		{
			possiblePlacings[index] = 5;
			index++;
			possiblePlacings[index] = $("#grid6").html();
			index++;
		}

	
		if( ($("#grid7").html() == $("#grid8").html() && !$("#grid9").hasClass("taken")) && ($("#grid7").hasClass("taken") && $("#grid8").hasClass("taken")) )
		{
			possiblePlacings[index] = 9;
			index++;
			possiblePlacings[index] = $("#grid7").html();
			index++;
		}
		if( ($("#grid8").html() == $("#grid9").html() && !$("#grid7").hasClass("taken")) && ($("#grid8").hasClass("taken") && $("#grid9").hasClass("taken")) )
		{
			possiblePlacings[index] = 7;
			index++;
			possiblePlacings[index] = $("#grid8").html();
			index++;
		}
		if( ($("#grid9").html() == $("#grid7").html() && !$("#grid8").hasClass("taken")) && ($("#grid9").hasClass("taken") && $("#grid7").hasClass("taken")) )
		{
			possiblePlacings[index] = 8;
			index++;
			possiblePlacings[index] = $("#grid9").html();
			index++;
		}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		if( ($("#grid1").html() == $("#grid4").html() && !$("#grid7").hasClass("taken")) && ($("#grid1").hasClass("taken") && $("#grid4").hasClass("taken")) )
		{
			possiblePlacings[index] = 7;
			index++;
			possiblePlacings[index] = $("#grid1").html();
			index++;
		}
		if( ($("#grid4").html() == $("#grid7").html() && !$("#grid1").hasClass("taken")) && ($("#grid4").hasClass("taken") && $("#grid7").hasClass("taken")) )
		{
			possiblePlacings[index] = 1;
			index++;
			possiblePlacings[index] = $("#grid4").html();
			index++;
		}
		if( ($("#grid1").html() == $("#grid7").html() && !$("#grid4").hasClass("taken")) && ($("#grid1").hasClass("taken") && $("#grid7").hasClass("taken")) )
		{
			possiblePlacings[index] = 4;
			index++;
			possiblePlacings[index] = $("#grid1").html();
			index++;
		}

		
		if( ($("#grid2").html() == $("#grid5").html() && !$("#grid8").hasClass("taken")) && ($("#grid2").hasClass("taken") && $("#grid5").hasClass("taken")) )
		{
			possiblePlacings[index] = 8;
			index++;
			possiblePlacings[index] = $("#grid2").html();
			index++;
		}
		if( ($("#grid5").html() == $("#grid8").html() && !$("#grid2").hasClass("taken")) && ($("#grid5").hasClass("taken") && $("#grid8").hasClass("taken")) )
		{
			possiblePlacings[index] = 2;
			index++;
			possiblePlacings[index] = $("#grid5").html();
			index++;
		}
		if( ($("#grid8").html() == $("#grid2").html() && !$("#grid5").hasClass("taken")) && ($("#grid8").hasClass("taken") && $("#grid2").hasClass("taken")) )
		{
			possiblePlacings[index] = 5;
			index++;
			possiblePlacings[index] = $("#grid8").html();
			index++;
		}

	
		if( ($("#grid3").html() == $("#grid6").html() && !$("#grid9").hasClass("taken")) && ($("#grid3").hasClass("taken") && $("#grid6").hasClass("taken")) )
		{
			possiblePlacings[index] = 9;
			index++;
			possiblePlacings[index] = $("#grid3").html();
			index++;
		}
		if( ($("#grid6").html() == $("#grid9").html() && !$("#grid3").hasClass("taken")) && ($("#grid6").hasClass("taken") && $("#grid9").hasClass("taken")) )
		{
			possiblePlacings[index] = 3;
			index++;
			possiblePlacings[index] = $("#grid6").html();
			index++;
		}
		if( ($("#grid9").html() == $("#grid3").html() && !$("#grid6").hasClass("taken")) && ($("#grid9").hasClass("taken") && $("#grid3").hasClass("taken")) )
		{
			possiblePlacings[index] = 6;
			index++;
			possiblePlacings[index] = $("#grid9").html();
			index++;
		}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		if( ($("#grid1").html() == $("#grid5").html() && !$("#grid9").hasClass("taken")) && ($("#grid1").hasClass("taken") && $("#grid5").hasClass("taken")) )
		{
			possiblePlacings[index] = 9;
			index++;
			possiblePlacings[index] = $("#grid1").html();
			index++;
		}
		if( ($("#grid5").html() == $("#grid9").html() && !$("#grid1").hasClass("taken")) && ($("#grid5").hasClass("taken") && $("#grid9").hasClass("taken")) )
		{
			possiblePlacings[index] = 1;
			index++;
			possiblePlacings[index] = $("#grid5").html();
			index++;
		}
		if( ($("#grid9").html() == $("#grid1").html() && !$("#grid5").hasClass("taken")) && ($("#grid9").hasClass("taken") && $("#grid1").hasClass("taken")) )
		{
			possiblePlacings[index] = 5;
			index++;
			possiblePlacings[index] = $("#grid9").html();
			index++;
		}

		
		if( ($("#grid3").html() == $("#grid5").html() && !$("#grid7").hasClass("taken")) && ($("#grid3").hasClass("taken") && $("#grid5").hasClass("taken")) )
		{
			possiblePlacings[index] = 7;
			index++;
			possiblePlacings[index] = $("#grid3").html();
			index++;
		}
		if( ($("#grid5").html() == $("#grid7").html() && !$("#grid3").hasClass("taken")) && ($("#grid5").hasClass("taken") && $("#grid7").hasClass("taken")) )
		{
			possiblePlacings[index] = 3;
			index++;
			possiblePlacings[index] = $("#grid5").html();
			index++;
		}
		if( ($("#grid7").html() == $("#grid3").html() && !$("#grid5").hasClass("taken")) && ($("#grid7").hasClass("taken") && $("#grid3").hasClass("taken")) )
		{
			possiblePlacings[index] = 5;
			index++;
			possiblePlacings[index] = $("#grid7").html();
			index++;
		}

		if(index != 0)
		{
			for(iterator=0; iterator<index+1;iterator+=2)
			{
				if(possiblePlacings[iterator+1] == "O")
				{
					
					aiPlaceInSpecificCell(possiblePlacings[iterator]);
					return 1;
				}
				else
				{
					if(blockingPlace == 0)
					{
						
						blockingPlace = possiblePlacings[iterator];
					}
				}
			}
			
			aiPlaceInSpecificCell(blockingPlace);
			return 1;
		}
		else
		{
			possiblePlacings = [];			
			return cellToPlace;
		}
	}

	
	function aiPlaceInSpecificCell(gridNumber)
	{
		var gridID;
		switch (gridNumber) 
		{
		    case 1:
		    	gridID = $('#grid1');
		    	changeGridSymbol(gridID, 2);
		        break;
		    case 2:
		        gridID = $('#grid2');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 3:
		        gridID = $('#grid3');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 4:
		        gridID = $('#grid4');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 5:
		        gridID = $('#grid5');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 6:
		        gridID = $('#grid6');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 7:
		        gridID = $('#grid7');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 8:
		        gridID = $('#grid8');
		        changeGridSymbol(gridID, 2);
		        break;
		    case 9:
		        gridID = $('#grid9');
		        changeGridSymbol(gridID, 2);
		}
	}


	function aiPlayerRandomTurn(playerCurrent, player1name)
	{
		var cellID = Math.floor((Math.random() * 9) + 1);
		var gridID = 0;
		
		switch (cellID) 
		{
		    case 1:
		    	gridID = $('#grid1');
		        break;
		    case 2:
		        gridID = $('#grid2');
		        break;
		    case 3:
		        gridID = $('#grid3');
		        break;
		    case 4:
		        gridID = $('#grid4');
		        break;
		    case 5:
		        gridID = $('#grid5');
		        break;
		    case 6:
		        gridID = $('#grid6');
		        break;
		    case 7:
		        gridID = $('#grid7');
		        break;
		    case 8:
		        gridID = $('#grid8');
		        break;
		    case 9:
		        gridID = $('#grid9');
		}
		var hasSymbol = getSymbolOnGrid(gridID);
		if(hasSymbol == 1)
		{
			var playerSymbol = getCurrPlayerSymbol(playerCurrent, player1name);
			changeGridSymbol(gridID, playerSymbol);
		}
		else
		{
			aiPlayerRandomTurn(playerCurrent, player1name);
		}
	}

	function checkForVictory()
	{
		var won = 0;

		if($("#grid3").hasClass("taken") && $("#grid5").hasClass("taken") && $("#grid7").hasClass("taken"))
		{
			if(($("#grid3").html() == $("#grid5").html()) && ($("#grid5").html() == $("#grid7").html())) 
		  	{
		  		$("#grid3").addClass("takenWinner");
		  		$("#grid5").addClass("takenWinner");
		  		$("#grid7").addClass("takenWinner");
			    won = 1;
		  	}
		} 

		if($("#grid1").hasClass("taken") && $("#grid5").hasClass("taken") && $("#grid9").hasClass("taken"))
		{
			if(($("#grid1").html() == $("#grid5").html()) && ($("#grid5").html() == $("#grid9").html())) 
		  	{
		  		$("#grid1").addClass("takenWinner");
		  		$("#grid5").addClass("takenWinner");
		  		$("#grid9").addClass("takenWinner");
			    won = 1;
		  	}
		} 

		if($("#grid1").hasClass("taken") && $("#grid2").hasClass("taken") && $("#grid3").hasClass("taken"))
		{
			if(($("#grid1").html() == $("#grid2").html()) && ($("#grid2").html() == $("#grid3").html())) 
		  	{
		  		$("#grid1").addClass("takenWinner");
		  		$("#grid2").addClass("takenWinner");
		  		$("#grid3").addClass("takenWinner");
			    won = 1;
		  	}
		}

		if($("#grid4").hasClass("taken") && $("#grid5").hasClass("taken") && $("#grid6").hasClass("taken"))
		{
			if(($("#grid4").html() == $("#grid5").html()) && ($("#grid5").html() == $("#grid6").html())) 
		  	{
		  		$("#grid4").addClass("takenWinner");
		  		$("#grid5").addClass("takenWinner");
		  		$("#grid6").addClass("takenWinner");
			    won = 1;
		  	}	
		}
		
		if($("#grid7").hasClass("taken") && $("#grid8").hasClass("taken") && $("#grid9").hasClass("taken"))
		{
		  	if(($("#grid7").html() == $("#grid8").html()) && ($("#grid8").html() == $("#grid9").html())) 
		  	{
		  		$("#grid7").addClass("takenWinner");
		  		$("#grid8").addClass("takenWinner");
		  		$("#grid9").addClass("takenWinner");
			    won = 1;
		  	}
		}	
		
		if($("#grid1").hasClass("taken") && $("#grid4").hasClass("taken") && $("#grid7").hasClass("taken"))
		{
			if(($("#grid1").html() == $("#grid4").html()) && ($("#grid4").html() == $("#grid7").html())) 
		  	{
		  		$("#grid1").addClass("takenWinner");
		  		$("#grid4").addClass("takenWinner");
		  		$("#grid7").addClass("takenWinner");
			    won = 1;
		  	}
		}

		if($("#grid2").hasClass("taken") && $("#grid5").hasClass("taken") && $("#grid8").hasClass("taken"))
		{
			if(($("#grid2").html() == $("#grid5").html()) && ($("#grid5").html() == $("#grid8").html())) 
		  	{
		  		$("#grid2").addClass("takenWinner");
		  		$("#grid5").addClass("takenWinner");
		  		$("#grid8").addClass("takenWinner");
			    won = 1;
		  	}	
		}
		  	
		if($("#grid3").hasClass("taken") && $("#grid6").hasClass("taken") && $("#grid9").hasClass("taken"))
		{
			if(($("#grid3").html() == $("#grid6").html()) && ($("#grid6").html() == $("#grid9").html())) 
		  	{
		  		$("#grid3").addClass("takenWinner");
		  		$("#grid6").addClass("takenWinner");
		  		$("#grid9").addClass("takenWinner");
			    won = 1;
		  	}
		}

	  	return won;
	}

	function setNextPlayer(playerCurrent, player1name, player2name)
	{
		if(playerCurrent == player1name)
		{
			return playerCurrent = player2name;
		}
		else
		{
			return playerCurrent = player1name;
		}
	}

	function changeGridSymbol(td, playerSymbol)
	{
		if(playerSymbol == 1)
		{
			td.html("X");
			td.addClass("taken");
		}
		else
		{
			td.html("O");
			td.addClass("taken");
		}
	}


	function getCurrPlayerSymbol(playerCurrent, player1name)
	{
		if(playerCurrent == player1name)
		{
			return 1;
		}
		else
		{
			return 2;
		}
	}

	function getSymbolOnGrid(td)
	{
		if(td.hasClass("taken"))
		{
			return 0;
		}
		else
		{
			//messages.html(" ");
			return 1;
		}
	}


	function playerTurnNotification(playerCurrent, turn)
		{
			turn.html("Player turn: " +playerCurrent);
		}
</script>