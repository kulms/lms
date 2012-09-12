<script language="JavaScript" type="text/JavaScript">
function showHideLayers()
{ 
  var i, visStr, obj, args = showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3)
  {
    if ((obj = findObj(args[i])) != null)
    {
      visStr = args[i+2];
      if (obj.style)
      {
        obj = obj.style;
        if(visStr == 'show') visStr = 'visible';
        else if(visStr == 'hide') visStr = 'hidden';
      }
      obj.visibility = visStr;
    }
  }
}
</script>
// * Dependencies * 
// this function requires the following snippets:
// JavaScript/readable_MM_functions/findObj
//
// Accepts a variable number of arguments, in triplets as follows:
// arg 1: simple name of a layer object, such as "Layer1"
// arg 2: ignored (for backward compatibility)
// arg 3: 'hide' or 'show'
// repeat...
//
// Example: showHideLayers(Layer1,'','show',Layer2,'','hide');