module.exports = function(Template) {

    var exec = require('child_process').exec;

    Template.say = function(templateId, cb) {
        var bieber = Template.app.models.Bieber;

        Template.findById(templateId, function (err, instance) {
            bieber.say(Template.resolveText(instance), cb);
        });
    };

    Template.resolveText = function(template) {
        return template.text;
    };

    Template.remoteMethod('say', {
        http: {path: '/say', verb: 'get'},
        accepts: {arg: 'id', type: 'number'},
        returns: {arg: 'data', type: 'object'}
    });
};
