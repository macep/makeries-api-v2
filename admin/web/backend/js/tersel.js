function isInteger(x) {
    return x % 1 === 0;
}
$( document ).ready(function() {
    $('td.editable').dblclick(function(){
        //var val = this.innerHTML.trim();
        var val = this.innerHTML.trim().replace(/<br>/g,"");
        var tdId = this.getAttribute('data');
        var tdFor = this.getAttribute('dataFor').trim();
        if (val.length==0 || (val.substring(0,6)!='<input' && val.substring(0,6)!='<texta')) {
            if (this.getAttribute('class').indexOf('textarea')) {
                this.innerHTML = '<textarea onchange="updateInlineTextarea('+tdId+', \''+tdFor+'\')" data="'+tdId+tdFor+'" class="form-control" style="height:100px;">'+val+'</textarea>';
            } else {
                this.innerHTML = '<input onchange="updateInlineInput('+tdId+', \''+tdFor+'\')" data="'+tdId+tdFor+'" type="text" value="'+val+'">';
            }
        }
    });
    $('td.editable input').change(function(){
        console.log('change', this);
    });
});

function updateInlineTextarea(tdId, tdFor) {
    var value = $('textarea[data="'+tdId+tdFor+'"]').val().replace(/\n/g,"<br>");
    updateInlineVal(value, tdId, tdFor);
}
function updateInlineInput(tdId, tdFor) {
    var value = $('input[data="'+tdId+tdFor+'"]').val();
    updateInlineVal(value, tdId, tdFor);
}
function updateInlineVal(value, tdId, tdFor) {
//console.log(hours);
//    if (hours.length==0 || isInteger(hours)) {
        var td = $("td.editable[data='"+tdId+"'][dataFor='"+tdFor+"']");
//console.log(td[0]);    
        if (td.length && td[0]) {
            td[0].innerHTML = value;
            var table = $(td[0]).closest('table');
            if (table.length && table[0]) {
                var tableName = table[0].getAttribute('data');
//console.log(tableName);
                $.get( "/update/inline", { value: value, field: tdFor, id:tdId, table: tableName,} )
                    .done(function( data ) {
                        //console.log( "Data Loaded: " + data );
                    })
                    .fail(function() {
                        alert( "eroare la salvarea orelor" );
                    });
            }
        }
//    }
}