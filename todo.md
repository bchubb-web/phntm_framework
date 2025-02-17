template rendering

# templates:
templates are frames, used to render the whole document, views are content of a page and are rendered by the template
default template is /phntm/Templates/Document.twig

when a page is instatiated we check for an overwritten $this->render_template, if so we strip the filename and add the directory to the twig loader
if not, set it to the default, and add THAT to the loader

if render_template is set to false, we skip the template rendering and render the view directly

# views:
when page is rendered, check for a set $this->render_view, if so, add the directory to the twig loader, 
if not, set it to the default and add THAT to the loader


src/Templates/
src/Views/
