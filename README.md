# FPDI Extended

Extensions for the FPDI and FPDF libraries with methods for convenience and quicker templating.

### Install

You can install FPDI Extended with [Composer](http://getcomposer.org). Add the following to the `require` key of your `composer.json` file:

    "m1ke/fpdi-ext": "dev-master"

### Authors

Written by [Mike Lehan](http://twitter.com/m1ke) and [Ground Control Skydiving](http://gcskydiving.com).

### Example

    $users=[ ['name'=>'Ben'], ['name'=>'Hero'], ['name'=>'Human'] ];

    $pdf = FPDIExt::template(__DIR__.'/files/email.pdf')->SetFont('FreeSans','',22);

    foreach ($users as $user){
    	$pdf->add_page_template()->block_text($user['name'], 75, 50);
    }
    
    $pdf->output_inline('file.pdf');

The extra `draw_grid` function lets you print a grid as described [here](http://coding.derkeiler.com/Archive/PHP/comp.lang.php/2007-12/msg00607.html). The intention is that you'd use this once to work out where to hard code your content markers during development.