jQuery(document).ready(function($) {

  if (typeof acf == 'undefined') { return; }

  acf.addFilter('color_picker_args', function(args, field){

    var key = 'field_6283de763bf62';
    var fields = acf.getFields({key: key});
    //console.log(fields)
    fields.forEach(() => {
      args.palettes = [ '#F6FCFF', '#000', '#fff', '#d33', '#d93', '#ee2', '#81d742', '#1e73be' ];
    })
    
    return args;
  })
})