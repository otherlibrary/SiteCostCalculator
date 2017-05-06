    function startLoading() {
      Element.show('mainAreaLoading');
      Element.hide('text_content');
    }
    function finishLoading() {
      Element.show('text_content');
      setTimeout("Effect.toggle('mainAreaLoading');", 1000);
    }

    function loadContent(id) {
      startLoading();
      new Ajax.Updater('text_content', 'whois.php', {method: 'post', postBody:'content='+ id +''});
      finishLoading();
    }