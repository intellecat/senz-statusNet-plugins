$(document).ready(function() {
    function InitColors(i, E) {
        switch (parseInt(E.id.slice(-1))) {
            case 1: default:
                $(E).val(rgb2hex($('body').css('background-color')));
                break;
            case 2:
                $(E).val(rgb2hex($('#content').css('background-color')));
                break;
            case 3:
                $(E).val(rgb2hex($('#aside_primary').css('background-color')));
                break;
            case 4:
                $(E).val(rgb2hex($('html body').css('color')));
                break;
            case 5:
                $(E).val(rgb2hex($('a').css('color')));
                break;
        }
    }

    function rgb2hex(rgb) {
        if (rgb.slice(0,1) == '#') { return rgb; }
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        return '#' + dec2hex(rgb[1]) + dec2hex(rgb[2]) + dec2hex(rgb[3]);
    }
    /* dec2hex written by R0bb13 <robertorebollo@gmail.com> */
    function dec2hex(x) {
        hexDigits = new Array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
        return isNaN(x) ? '00' : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    }

    function UpdateColors(S) {
        C = $(S).val();
        switch (parseInt(S.id.slice(-1))) {
            case 1: default:
                $('body').css({'background-color':C});
                break;
            case 2:
                $('#content, #site_nav_local_views .current a').css({'background-color':C});
                break;
            case 3:
                $('#aside_primary').css({'background-color':C});
                break;
            case 4:
                $('html body').css({'color':C});
                break;
            case 5:
                $('a').css({'color':C});
                break;
        }
    }

    function UpdateFarbtastic(e) {
        f.linked = e;
        f.setColor(e.value);
    }

    function UpdateSwatch(e) {
        $(e).css({"background-color": e.value,
                  "color": f.hsl[2] > 0.5 ? "#000": "#fff"});
    }

    function SynchColors(e) {
        var S = f.linked;
        var C = f.color;

        if (S && S.value && S.value != C) {
            S.value = C;
            UpdateSwatch(S);
            UpdateColors(S);
        }
    }

    function InitFarbtastic() {
        $('#settings_design_color').append('<div id="color-picker"></div>');
        $('#color-picker').hide();

        f = $.farbtastic('#color-picker', SynchColors);
        swatches = $('#settings_design_color .swatch');
        swatches.each(InitColors);
        swatches
            .each(SynchColors)
            .blur(function() {
                tv = $(this).val();
                $(this).val(tv.toUpperCase());
                (tv.length == 4) ? ((tv[0] == '#') ? $(this).val('#'+tv[1]+tv[1]+tv[2]+tv[2]+tv[3]+tv[3]) : '') : '';
             })
            .focus(function() {
                $('#color-picker').show();
                UpdateFarbtastic(this);
            })
            .change(function() {
                UpdateFarbtastic(this);
                UpdateSwatch(this);
                UpdateColors(this);
            }).change();
    }
    
    function previewTheme(theme){
        $('body').css('background-image','url("'+theme.image+'")')
                .css('background-repeat',theme.tiled ? 'repeat' : 'no-repeat')
                .css('background-attachment','scroll')
                .css('background-color',theme.background_color)
                .css('color',theme.text_color);
        $('#aside_primary').css('background-color',theme.sidebar_fill_color);
        $('a').css('color',theme.link_color);
    }
    
    function themeSwitch(themes,i){
        $('#Theme'+i).click(function(){
            previewTheme(themes[i]);
            
            var swatches = $('#settings_design_color .swatch');
            swatches.each(function (i, E){
                InitColors(i, E);
                UpdateSwatch(E);
            });
            
            $('#themes .current').removeClass('current');
            $(this).addClass('current');
            
            $('#selected_theme_id').val(i);
            $('#modefied').val('false');
            
            if(themes[i].tiled)
                $('#design_background-image_repeat').attr('checked','checked');
            else
                $('#design_background-image_repeat').removeAttr('checked');
            
            return false;
        });
    }

    var f, swatches;
    InitFarbtastic();
    $('#form_settings_design').bind('reset', function(){
        setTimeout(function(){
            swatches.each(function(){UpdateColors(this);});
            $('#color-picker').remove();
            swatches.unbind();
            InitFarbtastic();
        },10);
    });
    
    $("#form_settings_design input").bind('change', function(){
        $('#modefied').val('true');
    });
    
    $("#form_settings_design input[type=file]").bind('change', function(){
        $('#selected_theme_id').val('0');
    });
    
    $('#color-picker').bind('mouseup', function(){
        $('#modefied').val('true');
    });

    $('#design_background-image_off').focus(function() {
        $('body').css({'background-image':'none'});
    });
    $('#design_background-image_on').focus(function() {
        $('body').css({'background-image':'url('+$('#design_background-image_onoff img')[0].src+')'});
        $('body').css({'background-attachment': 'fixed'});
    });

    $('#design_background-image_repeat').click(function() {
        ($(this)[0].checked) ? $('body').css({'background-repeat':'repeat'}) : $('body').css({'background-repeat':'no-repeat'});
    });
    
    var themes = twitterThemes();
    for(var i=1;i<=16;i++){
        themeSwitch(themes,i);
    }
});

function twitterThemes(){
    var themes =
    {
      "6":
      {
        "sidebar_fill_color": "#A0C5C7", "image": "http://static.leihou.com/v319001/images/themes/bg-6.gif", "text_color": "#333333", "background_color": "#709397", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-6.gif", "tiled": false, "sidebar_border_color": "#86A4A6", "link_color": "#FF3300"
      }
      , "11":
      {
        "sidebar_fill_color": "#E5507E", "image": "http://static.leihou.com/v319001/images/themes/bg-11.gif", "text_color": "#362720", "background_color": "#FF6699", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-11.gif", "tiled": true, "sidebar_border_color": "#CC3366", "link_color": "#B40B43"
      }
      , "7":
      {
        "sidebar_fill_color": "#F3F3F3", "image": "http://static.leihou.com/v319001/images/themes/bg-7.gif", "text_color": "#333333", "background_color": "#EBEBEB", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-7.gif", "tiled": false, "sidebar_border_color": "#DFDFDF", "link_color": "#990000"
      }
      , "12":
      {
        "sidebar_fill_color": "#FFF7CC", "image": "http://static.leihou.com/v319001/images/themes/bg-12.gif", "text_color": "#0C3E53", "background_color": "#BADFCD", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-12.gif", "tiled": false, "sidebar_border_color": "#F2E195", "link_color": "#FF0000"
      }
      , "8":
      {
        "sidebar_fill_color": "#EADEAA", "image": "http://static.leihou.com/v319001/images/themes/bg-8.gif", "text_color": "#333333", "background_color": "#8B542B", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-8.gif", "tiled": false, "sidebar_border_color": "#D9B17E", "link_color": "#9D582E"
      }
      , "13":
      {
        "sidebar_fill_color": "#ffffff", "image": "http://static.leihou.com/v319001/images/themes/bg-13.gif", "text_color": "#333333", "background_color": "#B2DFDA", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-13.gif", "tiled": false, "sidebar_border_color": "#eeeeee", "link_color": "#93A644"
      }
      , "9":
      {
        "sidebar_fill_color": "#252429", "image": "http://static.leihou.com/v319001/images/themes/bg-9.gif", "text_color": "#666666", "background_color": "#1A1B1F", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-9.gif", "tiled": false, "sidebar_border_color": "#181A1E", "link_color": "#2FC2EF"
      }
      , "14":
      {
        "sidebar_fill_color": "#efefef", "image": "http://static.leihou.com/v319001/images/themes/bg-14.gif", "text_color": "#333333", "background_color": "#131516", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-14.gif", "tiled": true, "sidebar_border_color": "#eeeeee", "link_color": "#009999"
      }
      , "15":
      {
        "sidebar_fill_color": "#C0DFEC", "image": "http://static.leihou.com/v319001/images/themes/bg-15.gif", "text_color": "#333333", "background_color": "#022330", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-15.gif", "tiled": false, "sidebar_border_color": "#a8c7f7", "link_color": "#0084B4"
      }
      , "16":
      {
        "sidebar_fill_color": "#DDFFCC", "image": "http://static.leihou.com/v319001/images/themes/bg-16.gif", "text_color": "#333333", "background_color": "#9AE4E8", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-16.gif", "tiled": false, "name": "Classic Twitter", "sidebar_border_color": "#BDDCAD", "link_color": "#0084B4"
      }
      ,
    "1":
      {
        "sidebar_fill_color": "#DDEEF6", "image": "http://static.leihou.com/v319001/images/themes/bg-1.gif", "text_color": "#333333", "background_color": "#C0DEED", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-1.gif", "tiled": false, "name": "Default", "sidebar_border_color": "#C0DEED", "link_color": "#0084B4"
      }
      , "2":
      {
        "sidebar_fill_color": "#DAECF4", "image": "http://static.leihou.com/v319001/images/themes/bg-2.gif", "text_color": "#663B12", "background_color": "#C6E2EE", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-2.gif", "tiled": false, "sidebar_border_color": "#C6E2EE", "link_color": "#1F98C7"
      }
      , "3":
      {
        "sidebar_fill_color": "#E3E2DE", "image": "http://static.leihou.com/v319001/images/themes/bg-3.gif", "text_color": "#634047", "background_color": "#EDECE9", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-3.gif", "tiled": false, "sidebar_border_color": "#D3D2CF", "link_color": "#088253"
      }
      , "4":
      {
        "sidebar_fill_color": "#95E8EC", "image": "http://static.leihou.com/v319001/images/themes/bg-4.gif", "text_color": "#3C3940", "background_color": "#0099B9", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-4.gif", "tiled": false, "sidebar_border_color": "#5ED4DC", "link_color": "#0099B9"
      }
      , "10":
      {
        "sidebar_fill_color": "#7AC3EE", "image": "http://static.leihou.com/v319001/images/themes/bg-10.gif", "text_color": "#3D1957", "background_color": "#642D8B", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-10.gif", "tiled": true, "sidebar_border_color": "#65B0DA", "link_color": "#FF0000"
      }
      , "5":
      {
        "sidebar_fill_color": "#99CC33", "image": "http://static.leihou.com/v319001/images/themes/bg-5.gif", "text_color": "#3E4415", "background_color": "#352726", "swatch": "http://static.leihou.com/v319001/images/themes/swatch-5.gif", "tiled": false, "sidebar_border_color": "#829D5E", "link_color": "#D02B55"
      }
      
    };
    return themes;
}
