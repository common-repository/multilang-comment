         google.load("elements", "1", {            
              packages: "transliteration"          
          });

      function onLoad() {
        var options = {
          sourceLanguage: 'en',            
          destinationLanguage: [mrcmlang],
          shortcutKey: 'ctrl+g',   
          transliterationEnabled: true
        };
 
        var control =
            new google.elements.transliteration.TransliterationControl(options);
       
	// Enable transliteration in comment form textarea. id = comment		
		var ids = ["comment"];	
        control.makeTransliteratable(ids);

	// Show the transliteration control which can be used to toggle between English and Kannada.
        control.showControl('translControl');
      }

      google.setOnLoadCallback(onLoad);
