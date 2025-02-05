FROM httpd:2.4.51

COPY miniformbuilder.apache.conf /usr/local/apache2/conf/miniformbuilder.apache.conf

RUN echo "Include /usr/local/apache2/conf/miniformbuilder.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf