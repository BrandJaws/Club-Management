@extends('__layouts.admin') @section('main')
<div id="tournament-vue-container">
	<div class="brackets tournamentBrackets">
    	<div id="doubleElimination" class="demo">
        	<div class="demo"></div>
        </div>
    </div>
</div>
@section('page-specific-scripts')

<script src="{{asset("assets/global/scripts/jquery.bracket.min.js")}}"></script>
<link href="{{asset("assets/global/css/jquery.bracket.min.css")}}" rel="stylesheet">
<script>

var bigData = {
  teams : [
    ["Team 1",  null ],
    ["Team 3",  "Team 4" ],
    ["Team 5",  "Team 6" ],
    ["Team 7",  "Team 8" ],
    ["Team 9",  "Team 10"],
    ["Team 11", "Team 12"],
    ["Team 13", "Team 14"],
    ["Team 15", "Team 16"]
  ],
  results : [[ /* WINNER BRACKET */
    [[3,5], [2,4], [6,3], [2,3], [1,5], [5,3], [7,2], [1,2]],
    [[1,2], [3,4], [5,6], [7,8]],
    [[9,1], [8,2]],
    [[1,3]]
  ], [         /* LOSER BRACKET */
    [[5,1], [1,2], [3,2], [6,9]],
    [[8,2], [1,2], [6,2], [1,3]],
    [[1,2], [3,1]],
    [[3,0], [1,9]],
    [[3,2]],
    [[4,2]]
  ], [         /* FINALS */
    [[3,8], [1,2]],
    [[2,1]]
  ]]
}



var resizeParameters = {
  teamWidth: 400,
  scoreWidth: 30,
  matchMargin: 50,
  roundMargin: 50,
  init: bigData,
};

$(function() {
	$('div#doubleElimination .demo').bracket(resizeParameters);
});


var resultsFirstSetOnwards = [[ /* WINNER BRACKET */
    [[[3,5],[3,5],[3,5],[3,5],[3,5]], [[2,4]], [[6,3]], [[2,3]], [[1,5]], [[5,3]], [[7,2]], [[1,2]]],
    [[[1,2]], [[3,4]], [[5,6]], [[7,8]]],
    [[[9,1]], [[8,2]]],
    [[[1,3]]]
], [         /* LOSER BRACKET */
    [[[5,1]], [[1,2]], [[3,2]], [[6,9]]],
    [[[8,2]], [[1,2]], [[6,2]], [[1,3]]],
    [[[1,2]], [[3,1]]],
    [[[3,0]], [[1,9]]],
    [[[3,2]]],
    [[[4,2]]]
], [         /* FINALS */
    [[[3,8]], [[1,2]]],
    [[[2,1]]]
]];

var ranks = [[ /* WINNER BRACKET */
    [[3,5], [2,4], [6,3], [2,3], [1,5], [5,3], [7,2], [1,2]],
    [[1,2], [3,4], [5,6], [7,8]],
    [[9,1], [8,2]],
    [[1,3]]
], [         /* LOSER BRACKET */
    [[5,1], [1,2], [3,2], [6,9]],
    [[8,2], [1,2], [6,2], [1,3]],
    [[1,2], [3,1]],
    [[3,0], [1,9]],
    [[3,2]],
    [[4,2]]
], [         /* FINALS */
    [[3,8], [1,2]],
    [[2,1]]
]];

$(document).ready(function(e){

    $('.brackets .jQBracket').children().each(function(bracketIndex){
		
        var mappedToActualBracketIndex;
        if($(this).hasClass('finals')){
            mappedToActualBracketIndex = 2;
        }else if($(this).hasClass('bracket')){
            mappedToActualBracketIndex = 0;
        }else if($(this).hasClass('loserBracket')){
            mappedToActualBracketIndex = 1;
        }

        var rounds = $(this).find('.round');
        //console.log(rounds);
        rounds.each(function(roundIndex){

//
            var matchesInRound = $(this).find('div.match');
            //console.log(matchesInRound);
            matchesInRound.each(function(matchIndex){
                var teamsInMatch = $(this).find('.team');
				var label = teamsInMatch.find('.label');
				var countOfScores = resizeParameters.scoreWidth * 1;
				var initialWidthLabel = $(teamsInMatch[0]).outerWidth();
				
                try{
                    //Create rank containers
                        var rankSet = ranks[mappedToActualBracketIndex][roundIndex][matchIndex];

                        //console.log(rankSet);
                        $(teamsInMatch[0]).prepend('<div class="score rankBox" style="width: '+resizeParameters.scoreWidth+'px;" data-resultid="result-11">'+rankSet[0]+'</div>');
                        $(teamsInMatch[1]).prepend('<div class="score rankBox" style="width: '+resizeParameters.scoreWidth+'px;" data-resultid="result-11">'+rankSet[1]+'</div>');
                            var scoreCardForMatch = resultsFirstSetOnwards[mappedToActualBracketIndex][roundIndex][matchIndex];
                            //Create score card containers
                            for(var scoreSetIndex in scoreCardForMatch){

                                var scoreSet = scoreCardForMatch[scoreSetIndex];
                                if(scoreSet != undefined){
									countOfScores += resizeParameters.scoreWidth;
                                    $(teamsInMatch[0]).append('<div class="score" style="width: '+resizeParameters.scoreWidth+'px;" data-resultid="result-11">'+scoreSet[0]+'</div>');
                                    $(teamsInMatch[1]).append('<div class="score" style="width: '+resizeParameters.scoreWidth+'px;" data-resultid="result-11">'+scoreSet[1]+'</div>');

                                }

                            }
							label.css('width',resizeParameters.teamWidth-countOfScores);
							//$(teamsInMatch[0]).css('width',resizeParameters.teamWidth);
							//$(teamsInMatch[1]).css('width',resizeParameters.teamWidth);

                }catch (e){
                    console.log(e);
                }
            });
        });

    });


//
//
//    $('.bracket .round').each(function(roundIndex){
//       var matchesInBracket = $(this).find('div.match');
//        matchesInBracket.each(function(matchIndex){
//           var teamsInMatch = $(this).find('.team');
//
//            //Create rank containers
//            var rankSet = ranks[0][roundIndex][matchIndex];
//            $(teamsInMatch[0]).prepend('<div class="score" style="width: 60px;" data-resultid="result-11">'+rankSet[0]+'</div>');
//            $(teamsInMatch[1]).prepend('<div class="score" style="width: 60px;" data-resultid="result-11">'+rankSet[1]+'</div>');
//
//
//            //Create score card containers
//            for(var scoreSetIndex in resultsFirstSetOnwards[0][roundIndex][matchIndex]){
//                var scoreSet = resultsFirstSetOnwards[0][roundIndex][matchIndex][scoreSetIndex];
//
//                $(teamsInMatch[0]).append('<div class="score" style="width: 60px;" data-resultid="result-11">'+scoreSet[0]+'</div>');
//                $(teamsInMatch[1]).append('<div class="score" style="width: 60px;" data-resultid="result-11">'+scoreSet[1]+'</div>');
//
//            }
//
//        });
//    });
//
//    $('.loserBracket .round').each(function(roundIndex){
//        var matchesInBracket = $(this).find('div.match');
//        matchesInBracket.each(function(matchIndex){
//            var teamsInMatch = $(this).find('.team');
//
//            //Create rank containers
//            var rankSet = ranks[1][roundIndex][matchIndex];
//            $(teamsInMatch[0]).prepend('<div class="score" style="width: 60px;" data-resultid="result-11">'+rankSet[0]+'</div>');
//            $(teamsInMatch[1]).prepend('<div class="score" style="width: 60px;" data-resultid="result-11">'+rankSet[1]+'</div>');
//
//            //Create score card containers
//            for(var scoreSetIndex in resultsFirstSetOnwards[1][roundIndex][matchIndex]){
//                var scoreSet = resultsFirstSetOnwards[1][roundIndex][matchIndex][scoreSetIndex];
//                $(teamsInMatch[0]).append('<div class="score" style="width: 60px;" data-resultid="result-11">'+scoreSet[0]+'</div>');
//                $(teamsInMatch[1]).append('<div class="score" style="width: 60px;" data-resultid="result-11">'+scoreSet[1]+'</div>');
//            }
//        });
//    });
//
//    $('.finals .round').each(function(roundIndex){
//        var matchesInBracket = $(this).find('div.match');
//        matchesInBracket.each(function(matchIndex){
//            var teamsInMatch = $(this).find('.team');
//
//            //Create rank containers
//            var rankSet = ranks[2][roundIndex][matchIndex];
//            $(teamsInMatch[0]).prepend('<div class="score" style="width: 60px;" data-resultid="result-11">'+rankSet[0]+'</div>');
//            $(teamsInMatch[1]).prepend('<div class="score" style="width: 60px;" data-resultid="result-11">'+rankSet[1]+'</div>');
//
//            //Create score card containers
//            for(var scoreSetIndex in resultsFirstSetOnwards[2][roundIndex][matchIndex]){
//                var scoreSet = resultsFirstSetOnwards[2][roundIndex][matchIndex][scoreSetIndex];
//                $(teamsInMatch[0]).append('<div class="score" style="width: 60px;" data-resultid="result-11">'+scoreSet[0]+'</div>');
//                $(teamsInMatch[1]).append('<div class="score" style="width: 60px;" data-resultid="result-11">'+scoreSet[1]+'</div>');
//            }
//        });
//    });



});




 


</script>



<!--<link href="{{asset("assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css")}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}"></script> 
<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")}}"></script>
<link rel="stylesheet" href="{{asset("assets/leagueViewStyles.css")}}" />
<link href="{{asset("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/custom/jquery.steps.min.js")}}"></script>
<link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script> 
<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script> 
<script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script> 
<script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script> 
<script src="{{asset("assets/pages/scripts/components-date-time-pickers.min.js")}}" type="text/javascript"></script> -->
{{-- @include("__vue_components.MessageBar.message-bar") --}} 
<script>
var _baseUrl ="{{url('')}}";
var vue = new Vue({
	el: "#tournament-vue-container",
	data: {
	},
	mounted:function(){
	},
	computed:{
	},
	methods: {
	},
});
</script> 
@endSection
@stop 