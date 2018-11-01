var sideBarSearchTypeCurrent = '';
var sideBarSearchSportCurrent = '';
var sideBarSearchLeagueCurrent = '';
var sideBarSearchNameCurrent = '';
var sideBarSearchDate = '';
var sideBarSearchPage = '';
var sideBarRefreshEventListOnly = false;

$(document).ready(function() {
    /*
    params = window.location.hash;
    if (params.length) {
      params.forEach(function(data) {
        datas = data.split('=');
        var varname = datas[0] + ' = "' + datas[1]+'"';
        eval(varname);
    
      })
    }
    */
    getHashUrlSearchVars();
    reloadSidebarSport();
    if (isHomePage()) {
        //if (window.location.hash.length>1) {
            sideBarSearch();
        //}
    }
    $('a.favBttn').live( "click", function() {
        checkIfHomePage();
        window.location.hash = '#stime=favorite';
        return false;
    });
    $('a.filterFavorite').live( "click", function() {
        if (this.className.indexOf('inactive')>=0) {
            return false;
        }
        checkIfHomePage();
        hash = '#stime=favorite';
        if (this.getAttribute('href').length>0) {
            hash += '&sdates='+this.getAttribute('href');
        }
        window.location.hash = hash;
        //$('a.filterFavorite').removeClass('active');
        //if (this.className.indexOf('bluebg')<0) {
        //    this.className += ' active';
        //}
        return false;
    });
    $('.sidebarBttns a').live( "click", function() {
        //if (sideBarSearchTypeCurrent != 'today' || sideBarSearchSportCurrent.length<1 || !isHomePage()) {
            resetSideBarHashVars();
            sideBarSearchTypeCurrent = this.getAttribute('href');
            $('div.sidebarBttns a').removeClass('active');
            $(this).addClass('active');
            setSideBarHash();
            reloadSidebarSport();
        //}
        return false;
    });    
    $('ul.sideMenu span.sportName').live( "click", function() {
        //if (sideBarSearchTypeCurrent != 'today' || sideBarSearchSportCurrent.length<1 || !isHomePage()) {
            resetSideBarHashVars();
            sideBarSearchSportCurrent = this.textContent;
            $('div.sideBarSport').removeClass('active');
            $(this.parentNode).addClass('active');
            setSideBarHash();
        //}
        return false;
    });
    $('.showHideSideBarLeagues').live( "click", function() {
        var sportId = $(this).attr('href');
//alert('SportId='+sportId);
        $('ul#sidebarSport_'+sportId).toggle();
        if ($('#sidebarSport_'+sportId).css('display') == 'none') {
        //if ($('#sidebarSport_'+sportId).html() != '') {
            $(this).text('+');
            //$(this).parent().removeClass('active');
        } else {
            $(this).text('-');
            //$(this).parent().addClass('active');
            if ($('#sidebarSport_'+sportId).html().length<15) {
                $.ajax({
                    type: "POST",
                    url: '/sportleague/sidebar/',
                    data: window.location.hash.substr(1)+'&sportId='+sportId+'&listonly=1',
                    success: function(data) {
                        $('#sidebarSport_'+sportId).html(data);
                    }
                });
            }
        }
        return false;    
    });
    $('ul.sideMenu div.moreSports').live( "click", function() {
        var el = document.querySelectorAll('ul.sideMenu div.moreSports span.count')[0];
        if (el.textContent == '+') {
            el.textContent = '-';
            jQuery("li.notfavorites").show(); 
        } else {
            el.textContent = '+';
            jQuery("li.notfavorites").hide(); 
        }
    });    
    $('.earlyDay').live( "click", function() {
        sideBarSearchDate = this.getAttribute('href');
        sideBarSearchPage = "";
        setSideBarHash();
        return false;
    });
    $('.sidebarSearchPageClick').live( "click", function() {
        if (isSearchPage()) {
            setSearchHash(this.getAttribute('href'));
        } else {
            sideBarSearchPage = this.getAttribute('href');
            setSideBarHash();
        }
        return false;
    });
    $('.sidebarLeagueId').live( "click", function() {
        resetSideBarHashVars();
        sideBarSearchSportCurrent = $(this).attr('sport');
        sideBarSearchLeagueCurrent = $(this).attr('league');
        setSideBarHash();
        
        return false;
    });
    $('form#sideBarSearchEvent').live( "submit", function() {
        sideBarSearchNameCurrent = document.querySelector("input[name='sevent']").value;
        setSideBarHash();
        return false;
    });
    $(window).on('hashchange', function() {
        if (isHomePage() || isSearchPage()) {
            sideBarSearch();
        }
    });    
});

function isHomePage() {
    if ('/' == document.location.pathname) {
        return true;
    }
    return false;
}

function isSearchPage() {
    if ('/search' == document.location.pathname) {
        return true;
    }
    return false;
}

function checkIfHomePage() {
    if (!isHomePage()) {
        window.history.pushState('OddsarchiveSearch', 'Odds Archive', '/');
    }
}

//SIDEBAR
function setSideBarHash() {
    checkIfHomePage();
    window.location.hash = getHash();
}

function resetSideBarHashVars() {
    //sideBarSearchTypeCurrent = '';
    sideBarSearchSportCurrent = '';
    sideBarSearchLeagueCurrent = '';
    sideBarSearchNameCurrent = '';
    sideBarSearchDate = '';
    sideBarSearchPage = '';
}

function getHash() {
    var hash = '#stime='+sideBarSearchTypeCurrent;
    if (sideBarSearchSportCurrent.length >0) {
        hash = hash + '&sport=' + sideBarSearchSportCurrent;
    }
    if (sideBarSearchLeagueCurrent.length >0) {
        hash = hash + '&league=' + sideBarSearchLeagueCurrent;
    }
    if (sideBarSearchNameCurrent.length >0) {
        hash = hash + '&name=' + sideBarSearchNameCurrent;
    }
    if (sideBarSearchDate.length) {
        hash = hash + '&date=' + sideBarSearchDate;
    }
    if (sideBarSearchPage.length) {
        hash = hash + '&page=' + sideBarSearchPage;
    }
    return hash;
}

function reloadSidebarSport() {
    $.post( "/sport/sidebar/?"+getHash().substr(1), function( data ) {
        $( "#sideBarSport" ).html( data );
    });
}

function sideBarSearch() {
    if (!isHomePage() && !isSearchPage()) {
        return false;
    }
    divChange = 'section[role="main"]'; 
    if (window.location.pathname == '/search') {
       divChange = '#showList' 
    }
    //return false;
    console.log("RESULT WILL BE DISPLAY IN : "+divChange);
    var parameters = window.location.hash.substr(1);
//console.log(parameters);    
    if (parameters.length<1) {
        sideBarSearchTypeCurrent = 'today';
        parameters = 'stime=today';
    }
//console.log(parameters);    
    //if (sideBarSearchSportCurrent == '' ) {
    //    reloadSidebarSport();
    //}
    var urlAjax = '/search/index/';
    //if (window.location.pathname == '/favorites/') {
    //    parameters = 'stime=future&favorites=1';
    //}
    if (sideBarRefreshEventListOnly) {
        $.ajax({
            type: "POST",
            url: urlAjax,
            data: parameters + '&listonly=1',
            success: function(data) {
               $('#searchOddsList').html(data);
               return false;
            }
        });
    } else {
        $.ajax({
            type: "POST",
            url: urlAjax,
            data: parameters,
            success: function(data) {
               $(divChange).html(data); 
            }
        });
    }
    sideBarRefreshEventListOnly = false;
}

//searchPage
function setSearchHash(pageNr) {
    if (isSearchPage()) {
        if (dateIsReversed()) {
            alert('Dates are reversed!!!!');
            return false;
        }
        
        var hash = 's=1';
        var tmp = $('#eventSearchName').val();
        if (tmp.length) {
            hash +='&name='+tmp;
        }
        tmp = $("input[name='stime']:checked").val();
        hash += '&stime='+tmp;
        if ('today' != tmp) {
            var tmp = $("input[name='sdates']").val();
            if (tmp.length) {
                hash += '&sdates='+tmp;
            }
            var tmp = $("input[name='sdatee']").val();
            if (tmp.length) {
                hash += '&sdatee='+tmp;
            }
        }
        tmp = $("select[name='ssport']").val();
        if (tmp.length) {
            hash += '&ssport='+tmp;
        }
//console.log(hash);
        tmp = $("select[name='sleague']").val();
        if (tmp.length && parseInt(tmp)) {
            hash += '&league='+tmp;
        }
        if (parseInt(pageNr)>1) {
            hash += '&page='+parseInt(pageNr);
        }
//console.log(hash);
        tmp = $("select[name='sevtype']").val();
        if (tmp.length) {
            hash += '&evtype='+tmp;
        }
        if (parseInt(pageNr)>1) {
            hash += '&page='+parseInt(pageNr);
        }
        
        //alert('button pressed');
        window.location.hash = hash;    
    }
}

function checkDates() {
    if('today' == $( "input:radio[name=stime]:checked" ).val()) {
        $("#sdates").attr('disabled','disabled');  
        $("#sdatee").attr('disabled','disabled');  
        $("#sdates").hide();
        $("#sdatee").hide();
    } else {
        $("#sdates").removeAttr('disabled');  
        $("#sdatee").removeAttr('disabled');  
        $("#sdates").show();
        $("#sdatee").show();
    }
}

function dateIsReversed() {
    var startDate = $('#sdates').datepicker('getDate');
    var   endDate = $('#sdatee').datepicker('getDate');
    if (null == startDate || null == endDate) {
        return false;
    }
    if (startDate > endDate) {
        return true;
    }
    return false;
}

function getHashUrlSearchVars(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('#') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
console.log(i+' var '+hash[0]+'='+hash[1]);
        var hashName = hash[0];
        var hashValue = hash[1];
        switch(hash[0]) {
            case 'stime':
                if (isHomePage()) {
                    if (hashValue != 'live' && hashValue!='early') {
                        hashValue = 'today';
                    }
                    $('div.sidebarBttns a').removeClass('active');
                    $('a#1sideBarSport'+hashValue[0].toUpperCase()+hashValue.slice(1)).addClass('active');
                    sideBarSearchTypeCurrent = hashValue;
                    console.log('START SEARCHTIME SET TO :'+hashValue);
                } else {
                    jQuery('input[name="stime"][value="'+hashValue+'"]').click().change();
                }
                break;
            case 'ssport':
                 jQuery('select[name="ssport"]').val(hash[1]);
                 break;
            case 'sdates':
                 jQuery('input[name="sdates"]').val(hash[1]);
                 break;
            case 'sdatee':
                 jQuery('input[name="sdatee"]').val(hash[1]);
                 break;
            case 'sname':
                 jQuery('input[name="sname"]').val(hash[1]);
                 break;
            case 'ssport':
console.log('assport in link');
                var sSport = document.querySelector("select[name='ssport']");
                sSport.val(hash[1]);
console.log('ssport='+hash[1]);
                reloadSportLeagus(hash[1]);
                //jQuery('select[name="ssport"]').val(hash[1]).change();
                break;
        }
    }
    if (sideBarSearchTypeCurrent.length<2) {
        sideBarSearchTypeCurrent = 'today';
    }
}