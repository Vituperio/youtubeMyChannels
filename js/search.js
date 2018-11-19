$(document).ready(function(){
  var request3,response3,realId;
});

// After the API loads, call a function to enable the search box.
function handleAPILoaded() {
  $('#search-button').attr('disabled', false);
}

// Search for a specified string.
function search(q) {
  var q = $('#query').val();

  request = gapi.client.youtube.search.list({
    q: q,
    maxResults: '5',
    type: 'channel',
    part: 'snippet'
  });
  request.execute(function(response) {
    var str = JSON.stringify(response.result, null, 2);
    $('#show').append('<pre style="text-align: left;">'+str+'</pre>');
  });
}


function searchChannel(channel_ID, channelName) {
  var date = new Date();
  var gmt = date.getTimezoneOffset().toString();


  var wContainer = $('#channels-container').width();
  nVideo = parseInt(wContainer/204);
  if(nVideo > 8){
    nVideo = 8;
  }


  if(gmt.indexOf('-') != -1){
    gmt = (gmt*-1)/60;
  } else {
    gmt = gmt/60;
  }
  date.setHours(23+gmt, 59, 59);
  date.setDate(date.getDate()-1);
  after = date.toISOString();
  channel_id = gapi.client.youtube.search.list({
    q: channelName,
    type: 'channel',
    part: 'snippet'
  });
  channel_id.execute(function(channelID){
    id = channelID.result;
    request2 = gapi.client.youtube.search.list({
      channelId: id.items[0].id.channelId,
      maxResults: nVideo,
      part: 'snippet',
      order: 'date'
    });
    request2.execute(function(response2) {
      str = JSON.stringify(response2.result, null, 2);
      var channel_wrapper = $('<div class=\'container'+channel_ID+'\'></div>');
      for (var i = 0; i < response2.items.length; i++) {
        var details = JSON.stringify(response2.result, null, 2);
        img = response2.items[i].snippet.thumbnails.medium.url;
        title = response2.items[i].snippet.title;
        videoId = response2.items[i].id.videoId;
        publishedAt = response2.items[i].snippet.publishedAt;
        publishedAt = new Date(publishedAt);
        date = publishedAt.toLocaleString();

        p = $('<div class=\'video-content video-wrap-'+i+'-'+channel_ID+'\'></div>').append('<a target=\'_blank\' href=\'http://www.youtube.com/watch?v='+videoId+'\'><img src=\''+img+'\' /><br><span class=\'video-date\'>'+date+'</span><br><span class=\'video-title\'>'+title+'</span><span class=\'video-duration\'></span></a>').wrap('<p></p>');
        $(channel_wrapper).append(p);

        searchVideo(videoId, i, channel_ID);
      }

      $('#channels-container').append("<h4 class='channeltitle'>"+response2.items[0].snippet.channelTitle+" <a class='deleteChannel' href='' onclick='deleteChannel(\""+channel_ID+"\")'><span class='delete-channel glyphicon glyphicon-remove'></span></a><br>");
      $('#channels-container').append(channel_wrapper);
    });
  });
}

function searchVideo(video_ID, n, id){
  var duration;
  request3 = gapi.client.youtube.videos.list({
    id: video_ID,
    part: 'contentDetails'
  });
  request3.execute(function(response3) {
    duration = response3.items[0].contentDetails.duration;

    dur = duration.replace('PT', '');
    dur = dur.replace('H', ':');
    dur = dur.replace('M', ':');
    dur = dur.replace('S', '');

    lastChar = dur.slice(-1);

    if(lastChar === ':'){
      dur = dur.slice(0, -1);
    }

    $('.video-wrap-'+n+'-'+id+' .video-duration').html(dur);
  });
}

function addZero(n){
  if(n<10){
    n = "0"+n;
  }
  return n;
}
