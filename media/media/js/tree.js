/*
 * Tree CSS 
 * Developed by: Reggie Gyan -> 26-7-2017
 * @Orcons Systems
 **/


$(".gyn-treeview").delegate("label input:checkbox", "change", function() {    
    var checkbox = $(this),
        nestedList = checkbox.parent().next().next(),
        selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");     
    if (checkbox.is(":checked")) {        
        return selectNestedListCheckbox.prop("checked", true);    
    }    
    selectNestedListCheckbox.prop("checked", false);
});