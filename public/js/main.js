$(function() {

  var from_$input = $('#input_from').pickadate({
      format: 'yyyy-mm-dd',
      }),
    from_picker = from_$input.pickadate('picker')

  var to_$input = $('#input_to').pickadate({
          format: 'yyyy-mm-dd',
      }),
    to_picker = to_$input.pickadate('picker');

  let currentURL = new URL(window.location.href);

  let params = new URLSearchParams(currentURL.search);

  console.log(params.get('toDate'));
  from_picker.set('select', params.get('fromDate'));
  to_picker.set('select', params.get('toDate'));

  // Check if there’s a “from” or “to” date to start with.
  if ( from_picker.get('value') ) {
    to_picker.set('min', from_picker.get('select'))
  }
  if ( to_picker.get('value') ) {
    from_picker.set('max', to_picker.get('select'))
  }

  // When something is selected, update the “from” and “to” limits.
  from_picker.on('set', function(event) {
    if ( event.select ) {
      to_picker.set('min', from_picker.get('select'))
    }
    else if ( 'clear' in event ) {
      to_picker.set('min', false)
    }
  })
  to_picker.on('set', function(event) {
    if ( event.select ) {
      from_picker.set('max', to_picker.get('select'))
    }
    else if ( 'clear' in event ) {
      from_picker.set('max', false)
    }
  })
});


function benchmarkDates(){
    event.preventDefault();
    let from_$input = $('#input_from').pickadate(),
        from_picker = from_$input.pickadate('picker'),
        fromDate = from_picker.get('select', 'yyyy-mm-dd');

    let to_$input = $('#input_to').pickadate(),
        to_picker = to_$input.pickadate('picker'),
        toDate = to_picker.get('select', 'yyyy-mm-dd');


    let currentURL = new URL(window.location.href);

    let params = new URLSearchParams(currentURL.search);

    params.set('fromDate', fromDate);
    params.set('toDate', toDate);

    currentURL.search = params.toString();
    window.location.href = currentURL;
}
