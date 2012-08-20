module Jekyll
	class GistTag < Liquid::Tag

		def initialize(tag_name, text, tokens)
			super
			@text = text.strip!
		end

		def render(context)
			gist_url = "https://gist.github.com/#{@text}"
			%Q(<script type="text/javascript" src="#{gist_url}.js"> </script>\n<noscript><p>The code is available on <a href="#{gist_url}">#{gist_url}</a></p></noscript>)
		end
	end
end

Liquid::Template.register_tag('gist', Jekyll::GistTag)
