$('.no-js').removeClass('no-js').addClass('js');

var template_path = $('html').data('path');

/* SVG Support for IE */
svg4everybody();

function has_cookie(name) {
  if (document.cookie.indexOf(name+'=true') >= 0) {
    return true;
  }
  return false;
}

if (has_cookie('contrast')) {
  $('html').addClass('contrast');
}
if (has_cookie('video_optin')) {
  set_video_optin();
}

$('#style-toggle-btn').click(function() {
  if ($('html').hasClass('contrast')) {
    document.cookie = "contrast=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
  } else {
    document.cookie = "contrast=true; path=/";
  }
    $('html').toggleClass('contrast');
});

$('#style-normal').click(function() {
  $('html').removeClass('contrast');
  document.cookie = "contrast=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
});

$('#style-contrast').click(function() {
  $('html').addClass('contrast');
  document.cookie = "contrast=true; path=/";
});

$(document).ready(function() {
  $(".video-optin").change(function() {
  if(this.checked) {
      set_video_optin_cookie();
  } else {
      unset_video_optin_cookie();
  }
});
});

function set_video_optin_cookie() {
  var date, expires;
  date = new Date();
  date.setTime(date.getTime()+(30*24*60*60*1000));
  expires = " expires="+date.toGMTString();
  document.cookie = "video_optin=true; path=/;"+expires;
  set_video_optin();
}

function unset_video_optin_cookie() {
  document.cookie = "video_optin=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
  $('.video-optin').prop( "checked", false );
  $(".player").hide();
}

function set_video_optin() {
  $('.video-optin').prop( "checked", true );
  $(".player").show();
}

/**
 * Add hash to url without scrolling
 *
 * @param String $url - it could be hash or url with hash
 *
 * @return void
 */
function addHashToUrl($url) {
  if ('' == $url || undefined == $url) {
    $url = '_'; // it is empty hash because if put empty string here then browser will scroll to top of page
  }
  $hash = $url.replace(/^.*#/, '');
  var $fx, $node = jQuery('#' + $hash);
  if ($node.length) {
    $fx = jQuery('<div></div>')
      .css({
        position: 'absolute',
        visibility: 'hidden',
        top: jQuery(window).scrollTop() + 'px'
      })
      .attr('id', $hash)
      .appendTo(document.body);
    $node.attr('id', '');
  }
  document.location.hash = $hash;
  if ($node.length) {
    $fx.remove();
    $node.attr('id', $hash);
  }
}

// Menü ein-/ausblenden.
$('.toggle').each(function() {

  var toggle_for = $('#' + $(this).data('for'));

  toggle_for.hide();

  $(this).click(function(e) {
    $(this).toggleClass('active');
    toggle_for.slideToggle();
  });
});

function count_parents() {
  return $('.current').parents('.active').length;
}

$(document).ready(function() {
  if (count_parents()==2||count_parents()==1) {
    $('.current').parents('.sub-container').show();
    $('.current').parents('.has-sub').addClass('open');
    $('.current').parents('.has-sub').find('.s_icon').replaceWith('<i class="s_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#minus"></use></svg></i>');
  }
});

$('#menu-main li.has-sub>a').on('click', function() {
  $(this).removeAttr('href');
  var element = $(this).parent('li');
  if (element.hasClass('open')) {
    element.removeClass('open');
    $(this).children('.s_icon').replaceWith('<i class="s_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#plus"></use></svg></i>');
    element.find('ul').slideUp();
  } else {
    element.addClass('open');
    $(this).children('.s_icon').replaceWith('<i class="s_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#minus"></use></svg></i>');
    element.children('ul').slideDown();
    element.siblings('li').children('ul').slideUp();
    element.siblings('li').removeClass('open');
    element.siblings('li').find('li').removeClass('open');
    element.siblings('li').find('ul').slideUp();
  }
  $('#menu-main').find('.has-sub').not('.open').find('.s_icon').replaceWith('<i class="s_icon"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#plus"></use></svg></i>');
});

//search+login
$(".btn-fade").click(function() {

  var area = $('#' + $(this).data('area')),
    parent = $('.fadein-area');

  if (area.hasClass('open')) {
    area.removeClass('open').slideUp('fast');
  } else {
    var open_area = parent.find('.open');
    if (open_area.length > 0) {
      open_area.removeClass('open').slideUp('fast');
      area.addClass('open').slideDown('fast');
      area.find('.input-focus').focus();
    } else {
      area.addClass('open').slideDown('fast');
      area.find('.input-focus').focus();
    }
  }
});

$(document).ready(function() {
  if ($('#login .error')) {
    $('.user-login .input-focus').focus();
  }
});

//cancel
$('.btn-cancel').click(function(e) {
  e.preventDefault();

  $('#search').removeClass('open').slideUp('fast');
  $('#btn-search a').focus();
});
// Mit Esc-Taste schließen
$(document).on('keyup', function(e) {
  if (e.keyCode == 27 && $('#search').hasClass('open')) {
    $('#search').removeClass('open').slideUp('fast');
    $('#btn-search a').focus();
  }
});

// Hash-Tag Elemente beim Laden der Seite anzeigen
var showSection = window.location.hash.substr(1);
if (showSection) {
  $('.a_open').removeClass('a_open').find('.a_content').hide();
  $('#' + showSection).addClass('a_open').find('.a_content').show();
  $(document).ready(function() {
    $('#' + showSection+' .a_icon').replaceWith('<i class="a_icon"><svg role="img" class="symbol plusminus" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#minus"></use></svg></i>');
    $('html, body').animate({
      scrollTop: $('#' + showSection).offset().top-150
    }, 500);
  });
}

//accordion

$('.accordion').addClass('js').find('.a_header').each(function(index, value) {
  $(this).wrap('<a class="a_link" href="#"></a>').parent().append('<i class="a_icon"><svg role="img" class="symbol plusminus" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#plus"></use></svg></i>');
})

/* Accordion */
$('.a_link').click(function(e) {
  e.preventDefault();
  var accLink = $(this);
  var accParent = $(this).parent();

  if (accParent.hasClass('a_open')) {
    $('.a_open .a_content').slideUp(500).promise().done(function() {
      accLink.find('.a_icon').replaceWith('<i class="a_icon"><svg role="img" class="symbol plusminus" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#plus"></use></svg></i>');
      $('.a_open').removeClass('a_open');
    });
  } else {
    $('.a_open .a_content').slideUp(500).promise().done(function() {
      $('.accordion').find('.a_icon').replaceWith('<i class="a_icon"><svg role="img" class="symbol plusminus" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#plus"></use></svg></i>');
      accLink.find('.a_icon').replaceWith('<i class="a_icon"><svg role="img" class="symbol plusminus" aria-hidden="true" focusable="false"><use xlink:href="' + template_path + '/img/icons.svg#minus"></use></svg></i>');
      $('html, body').animate({
        scrollTop: accParent.offset().top-150
      }, 500);

      $('.a_open').removeClass('a_open');
      accLink.next().slideDown(500);
      accParent.addClass('a_open');
      addHashToUrl(accParent.attr('id'));
    });
  }
  return false;
});

$('.a_link').mouseup(function() {
  this.blur();
});

// Add sticky class to body when scrolling
$(function() {
  $(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll > 2) {
      $('body').addClass('sticky');
    }

    if (scroll <= 2) {
      $('body').removeClass('sticky');
    }
  });
});
