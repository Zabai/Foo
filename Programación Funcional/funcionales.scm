(define (fibo n)
    (if (= n 0)
        0
        (if (= n 1)
            1
            (+ (fibo (- n 1)) (fibo (- n 2)))
        )
    )
)

(define (expo b n)
    (if (= n 0)
        1
        (* b (expo b (- n 1)))
    )
)

(define (minimo lst)
    (if (null? (cdr lst))
        (car lst)
        (if (< (car lst) (minimo (cdr lst)))
            (car lst)
            (minimo (cdr lst))
        )
    )
)

(define (inserta elem lst)
    (if (null? lst)
        (list elem)
        (if (< elem (car lst))
            (cons elem lst)
            (cons (car lst) (inserta elem (cdr lst)))
        )
    )
)

(define (concatena listA listB)
    (if (null? listA)
        listB
        (cons (car listA) (concatena (cdr listA) listB))
    )
)

#(Hacerlo con un loop en un solo metodo)
(define (invierte lst)
    (invierteAux lst '())
)
(define (invierteAux lst reversed)
    (if (null? lst)
        reversed
        (invierteAux (cdr lst) (cons (car lst) reversed))
    )
)

(define (elimina elem lst)
    (eliminaAux elem lst '())
)
(define (eliminaAux elem lst deleted)
    (if (null? lst)
        (reverse deleted)
        (if (equal? elem (car lst))
            (eliminaAux elem (cdr lst) deleted)
            (eliminaAux elem (cdr lst) (cons (car lst) deleted))
        )
    )
)

(define (repetidos lst)
    #f
)

(display "(fibo 7): ")
(display (fibo 7))
(newline)

(display "(expo 2 3): ")
(display (expo 2 3))
(newline)

(display "(minimo '(3 6 2 8 11)): ")
(display (minimo '(3 6 2 8 11)))
(newline)

(display "(inserta 6 '(2 3 8 12)): ")
(display (inserta 6 '(2 3 8 12)))
(newline)

(display "(concatena '(1 2) '(3 (4 5))): ")
(display (concatena '(1 2) '(3 (4 5))))
(newline)

(display "(invierte '(1 2 (3 4) 5)): ")
(display (invierte '(1 2 (3 4) 5)))
(newline)

(display "(elimina 3 '(1 2 3 4 5)): ")
(display (elimina 3 '(1 2 3 4 5)))
(newline)

#(repetidos '(1 2 3 3 4 5 5))
(newline)