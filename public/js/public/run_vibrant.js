


(function() {
  document.addEventListener('DOMContentLoaded', function() {
    var example, examples, i, img, len, results;
    examples = document.querySelectorAll('img');
    results = [];
    for (i = 0, len = examples.length; i < len; i++) {
      //example = examples[i];
      img = examples[i];
      //img.setAttribute('src', img.getAttribute('data-src'));
      results.push(img.addEventListener('load', function(e) {
        var color, colorHolder, colorName, colors, j, len1, panel, profile, profileName, profiles, results1, vibrant;
        vibrant = new Vibrant(this);
        panel = e.target;
        
        panel.style.backgroundColor = vibrant.VibrantSwatch.getHex();
        panel.style.color = vibrant.VibrantSwatch.getTitleTextColor();
        //colors = document.createElement('div');
        //colors.classList.add('colors');
        //panel.querySelector('.panel-body').appendChild(colors);
        profiles = ['VibrantSwatch', 'MutedSwatch', 'DarkVibrantSwatch', 'DarkMutedSwatch', 'LightVibrantSwatch', 'LightMutedSwatch'];
        results1 = [];
        results1.push(panel);
        // for (j = 0, len1 = profiles.length; j < len1; j++) {
        //   profileName = profiles[j];
        //   profile = vibrant[profileName];
        //   if (!profile) {
        //     continue;
        //   }
        //   //colorHolder = document.createElement('div');
        //   //color = document.createElement('div');
        //   //color.classList.add('color');
        //   //color.classList.add('shadow-z-1');
        //   //color.style.backgroundColor = profile.getHex();
        //   //colorName = document.createElement('span');
        //   //colorName.innerHTML = profileName.substring(0, profileName.length - 6);
        //   //colorHolder.appendChild(color);
        //   //colorHolder.appendChild(colorName);
          
        // }
        return results1;
      }));
    }
    return results;
  });

}).call(this);