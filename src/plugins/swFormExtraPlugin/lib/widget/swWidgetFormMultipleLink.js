
widgets = {};

widgets.link = function(w) {
  var element = $(w);
  
  this.add_action = element.attr('add_action');
  this.del_action = element.attr('del_action');
  this.related_form_id = element.attr('related_form_id');
  this.rid = $('#' + this.related_form_id).val();
  this.submit = $('.btn', element);
  this.title = $('input[name=title]', element);
  this.link = $('input[name=link]', element);
  this.links2 = $('.links2', element);
  this.multiple_item = $('.multiple_item', element)
  this.msg = $('.msg', element);
  this.deletes = $('.delete');
 
  this.submit.bind('click', {widget: this} , function(event){
    var widget = event.data.widget;
    widget.add(widget);
  });
  
  $('.delete', element).live('click', {widget: this}, function(event){
    var widget = event.data.widget;
    widget.item = $(event.target);
    widget.del(widget);
  });  
}

widgets.link.prototype.del = function(widget) {
  var data = {};
  data.lid = widget.item.attr('lid');
  var msg = widget.msg;
  var action = widget.del_action;
  
  if (surgical.validators.isEmpty(data.lid)) {
    surgical.showMessage(msg,
            'Invalid value',
            true);
    return false;
  }
  
  $.ajax({
      type: 'POST',
      url: surgical.url_for(action),
      data: data,
      success: function(data) {
        data = $.parseJSON(data);
        surgical.showMessage(msg,
          data.msg,
          true);
        widget.item.parent().remove();
      },
      error: function (data, textStatus, errorThrown) {
        if (data.status == '404') {
          surgical.showMessage(msg,
            data.statusText,
            true);
        }
        if (data.status == '500' || data.status == '501') {
          surgical.showMessage(msg,
            $.parseJSON(data.responseText).msg,
            true);
        }
      }
    });
};


widgets.link.prototype.add = function(widget) {
  var data = {};
  data.title = widget.title.val();
  data.link = widget.link.val();
  data.rid = widget.rid;
  var msg = widget.msg;
  var action = widget.add_action;
  
  if((data.link.indexOf('http://') 
      + data.link.indexOf('ftp://') 
      + data.link.indexOf('https://')) == -3) {
    data.link = 'http://' + data.link;
  }
  
  if (surgical.validators.isEmpty(data.title)) {
    surgical.showMessage(msg,
            'Invalid Title',
            true);
    return false;
  }
  
  if (!surgical.validators.isUrl(data.link)) {
    surgical.showMessage(msg,
            'Invalid Url (add protocol http, https, ftp)',
            true);
    return false;
  }
  
  if (surgical.validators.isEmpty(data.rid)) {
    surgical.showMessage(msg,
            'Invalid Value',
            true);
    return false;
  }
  
  $.ajax({
      type: 'POST',
      url: surgical.url_for(action),
      data: data,
      success: function(data) {
        data = $.parseJSON(data);
        surgical.showMessage(msg,
          data.msg,
          true);

        if (typeof widget.links !== 'undefined' && widget.links.length !== 0) {
          var row = '<div class="row label notice"><a href="' + data.link + '" target="_blank">\n\
                  ' + data.title + '</a><span class="delete" lid="'+ data.id +'"> X </span></div>';
          widget.links.append(row);
        } else {
          var row = '<div class="multiple_item">\n\
                        <label for="link_">' + data.title +  '</label>\n\
                        <input readonly name ="link_' + data.id + '" value="' +  data.link + '" />\n\
                        <span class="delete" lid="'+ data.id +'"> X </span>\n\
                     </div>';
          widget.links2.append(row);
        }
        widget.title.val('');
        widget.link.val('');
      },
      error: function (data, textStatus, errorThrown) {
        if (data.status == '404') {
          surgical.showMessage(msg,
            data.statusText,
            true);
        }
        if (data.status == '500' || data.status == '501') {
          surgical.showMessage(msg,
            $.parseJSON(data.responseText).msg,
            true);
        }
      }
    });
};

$(document).ready(function() {
  var widget = $('.multiple_widget');
  widget.each(function(i, w){
    var myWidget = new widgets.link(w);
    console.log(myWidget);
  });
});