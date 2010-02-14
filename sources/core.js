/**************************************
 * The js file script                 *
 * ================================== *
 * nihil v0.2                         * 
 * ************************************/
    
function spoil (spoiler)
{
    
    var el = document.getElementById (spoiler);
    
    if (el.style.display == 'block')
        el.style.display = 'none';
    else
        el.style.display = 'block';
			
}

