$(document).ready(function(){
  $('#channel-container').hide();

  setTimeout(function(){
    channelsList();
  }, 3000);

});

/* FUNCTIONS */
function channelChoise(choise){
  searchChannel(choise);
}

function channelsList(){
  $.post('php/script.php', {func: 'getAllChannels'}, function(responses){
    $.each(JSON.parse(responses), function(key, channel){
      searchChannel(channel.cid, channel.cname);
    });
  }).done(function(){
      $("div#load").fadeOut("slow");
      setTimeout(function(){

        $('#channel-container').show();
        $('a.deleteChannel').click(function(e){
          e.preventDefault();
          e.stopPropagation();
        });
      }, 1000);
  });
}

function closePanel(id){
  clearForm(id);
}

function clearForm(selector){
  $(selector).remove();
}

// ADD CHANNEL FUNCTION
function addChannelPage(){
  clearForm('#add-channel-form');
  form = $('<div id="add-channel-form-wrap"></div>');
  formWrap = $('<div id="add-channel-form"></div>')

  closeBtn = $('<button></button>');
  closeBtn.attr({
    name: 'close-btn',
    id: 'close-btn',
    class: 'btn btn-primary',
    onclick: 'closePanel("#add-channel-form-wrap");',
  }).css({
    visibility: 'visible'
  }).html('<span class="glyphicon glyphicon-remove"></span>');
  formWrap.append(closeBtn);
  
  channelNameLabel = $('<label>Name: </label>');
  channelName = $('<input></input>');
  channelName.attr({
    required: true,
    name: 'channel-name',
    id: 'channel-name',
    class: 'form-control'
  });

  channelTypeLabel = $('<label>Type: </label>');
  channelType = $('<select></select>');
  channelType.append('<option value=""> - SELEZIONA UN VALORE - </option>');
  $.post('php/script.php', {func: 'getTypes'}, function(types){
    $.each(JSON.parse(types), function(key, value){
      channelType.append('<option value="'+key+'">'+value+'</option>');
      console.log('<option value="'+key+'">'+value+'</option>');
    });
  });
  channelType.attr({
    required: true,
    name: 'channel-type',
    id: 'channel-type',
    class: 'form-control'
  });

  channelBtn = $('<button></button>');
  channelBtn.attr({
    name: 'channel-save',
    id: 'channel-save',
    onclick: 'addChannel();',
    class: 'btn btn-primary',
  }).text('Salva');
  
  formWrap.append(channelNameLabel);
  formWrap.append(channelName);
  formWrap.append('<br>');
  formWrap.append(channelTypeLabel);
  formWrap.append(channelType);
  formWrap.append('<br>');
  formWrap.append(channelBtn);

  form.append(formWrap);
  form.css({
    'padding-top': '200px',
    background: 'rgba(0,0,0,0.9)',
  });

  $('body').append(form);
}
function addChannel(){
  $.post('php/script.php', {func: 'addChannel', channelName: $('#channel-name').val(), channelType: $('#channel-type').val()}, function(responses){
    alert(responses);
  });
  closePanel('#add-channel-form');
}

// ADD CHANNEL FUNCTION
function addTypePage(){
  clearForm('#add-type-form');
  form = $('<div id="add-type-form"></div>');
  closeBtn = $('<button></button>');
  closeBtn.attr({
    name: 'close-btn',
    id: 'close-btn',
    class: 'btn btn-primary',
    onclick: 'closePanel("#add-type-form");',
  }).css({
    visibility: 'visible'
  }).html('<span class="glyphicon glyphicon-remove"></span>');
  form.append(closeBtn);
  
  channelTypeLabel = $('<label>Type: </label>');
  channelType = $('<input></input>');
  channelType.attr({
    required: true,
    name: 'channel-type',
    id: 'channel-type',
    class: 'form-control'
  });

  channelBtn = $('<button></button>');
  channelBtn.attr({
    name: 'type-save',
    id: 'type-save',
    onclick: 'addType();',
    class: 'btn btn-primary',
  }).text('Salva');
  
  form.append(channelTypeLabel);
  form.append(channelType);
  form.append(channelBtn);
  form.css({
    height: '100%',
    width: '100%',
    position: 'absolute',
    display: 'block',
    top: 0,
    left: 0,
    'padding-top': '200px',
    background: 'rgba(0,0,0,0.9)',
    'text-align': 'center',
    margin: 'auto',
  });

  $('body').append(form);
}
function addType(){
  $.post('php/script.php', {func: 'addType', channelType: $('#channel-type').val()}, function(responses){
    alert(responses);
  });
  closePanel('#add-type-form');
}

function getChannelsType(channel_type){
  $('#channels-container').empty();
  $.post('php/script.php', {func: 'getChannelsType', channelType: channel_type}, function(responses){ 
    $.each(JSON.parse(responses), function(key, channel){
      searchChannel(channel.cid, channel.cname);
    });
  });
}

function deleteChannel(channelDel){
  var conf = confirm('Are you sure to delete this channel: '+channelDel+'?');
  if(conf){
    $.post('php/script.php', {func: 'delChannel', channelID: channelDel}, function(responses){
      alert(responses);
    });
  } else{

  }
}
